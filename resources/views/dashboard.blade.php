@extends('app')

@section('header', 'Dashboard')
@section('title', 'Dashboard - Medical Appointment Manager')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Rendez-vous</h6>
                    <h3 class="fw-bold">{{ $stats['total_appointments'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Confirmés</h6>
                    <h3 class="fw-bold text-success">{{ $stats['confirmed'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">En Attente</h6>
                    <h3 class="fw-bold text-warning">{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted">Annulés</h6>
                    <h3 class="fw-bold text-danger">{{ $stats['cancelled'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">Rendez-vous Récents</h5>
        </div>
        <div class="card-body">
            @if($appointments->isEmpty())
                <p class="text-muted text-center py-4">Aucun rendez-vous pour le moment.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>{{ auth()->user()->isDoctor() ? 'Patient' : 'Médecin' }}</th>
                                <th>Service</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->formatted_date }}</td>
                                    <td>
                                        {{ auth()->user()->isDoctor() 
                                            ? $appointment->patient->name 
                                            : $appointment->doctor->name }}
                                    </td>
                                    <td>{{ $appointment->service->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ $appointment->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
