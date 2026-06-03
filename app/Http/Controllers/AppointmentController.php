<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isDoctor()) {
            $appointments = Appointment::where('doctor_id', $user->id)
                ->with(['patient', 'service'])
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
        } else {
            $appointments = Appointment::where('patient_id', $user->id)
                ->with(['doctor', 'service'])
                ->orderBy('appointment_date', 'desc')
                ->paginate(10);
        }

        return view('appointments_index', compact('appointments'));
    }

    public function create()
    {
        if (auth()->user()->isDoctor()) {
            abort(403, 'Doctors cannot create appointments');
        }

        $doctors = User::where('role', 'doctor')->get();
        $services = Service::all();

        return view('appointments_create', compact('doctors', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $validated['patient_id'] = auth()->id();
        $validated['status'] = 'pending';

        Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous créé avec succès!');
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        return view('appointments_show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $doctors = User::where('role', 'doctor')->get();
        $services = Service::all();

        return view('appointments_edit', compact('appointment', 'doctors', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Rendez-vous modifié avec succès!');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous supprimé avec succès!');
    }
}
