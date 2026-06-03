<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isDoctor()) {
            $appointments = Appointment::where('doctor_id', $user->id)
                ->with(['patient', 'service'])
                ->orderBy('appointment_date', 'desc')
                ->limit(10)
                ->get();

            $stats = [
                'total_appointments' => Appointment::where('doctor_id', $user->id)->count(),
                'confirmed' => Appointment::where('doctor_id', $user->id)->where('status', 'confirmed')->count(),
                'pending' => Appointment::where('doctor_id', $user->id)->where('status', 'pending')->count(),
                'cancelled' => Appointment::where('doctor_id', $user->id)->where('status', 'cancelled')->count(),
            ];
        } else {
            $appointments = Appointment::where('patient_id', $user->id)
                ->with(['doctor', 'service'])
                ->orderBy('appointment_date', 'desc')
                ->limit(10)
                ->get();

            $stats = [
                'total_appointments' => Appointment::where('patient_id', $user->id)->count(),
                'confirmed' => Appointment::where('patient_id', $user->id)->where('status', 'confirmed')->count(),
                'pending' => Appointment::where('patient_id', $user->id)->where('status', 'pending')->count(),
                'cancelled' => Appointment::where('patient_id', $user->id)->where('status', 'cancelled')->count(),
            ];
        }

        return view('dashboard', compact('appointments', 'stats'));
    }
}
