<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Appointment;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/appointments', function (Request $request) {
        $query = Appointment::with(['patient', 'doctor', 'service']);

        $user = auth()->user();
        if ($user->isDoctor()) {
            $query->where('doctor_id', $user->id);
        } else {
            $query->where('patient_id', $user->id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('doctor', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        return response()->json($query->orderBy('appointment_date', 'desc')->get());
    });

    Route::post('/appointments', function (Request $request) {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $validated['doctor_id'],
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment->load(['patient', 'doctor', 'service'])
        ], 201);
    });
});
