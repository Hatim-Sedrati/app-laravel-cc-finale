@extends('app')

@section('header', 'Détails du Rendez-vous')
@section('title', 'Rendez-vous - Medical Appointment Manager')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Rendez-vous #{{ $appointment->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Patient</h6>
                            <p class="fw-bold">{{ $appointment->patient->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Médecin</h6>
                            <p class="fw-bold">{{ $appointment->doctor->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Date et Heure</h6>
                            <p class="fw-bold">{{ $appointment->formatted_date }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Statut</h6>
                            <p>
                                <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ $appointment->status_label }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Service</h6>
                            <p class="fw-bold">{{ $appointment->service->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Tarif</h6>
                            <p class="fw-bold">{{ number_format($appointment->service->price, 2, ',', ' ') }} €</p>
                        </div>
                    </div>

                    @if($appointment->notes)
                        <div class="mb-4">
                            <h6 class="text-muted">Notes</h6>
                            <p>{{ $appointment->notes }}</p>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Créé le</h6>
                            <p class="small">{{ $appointment->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Modifié le</h6>
                            <p class="small">{{ $appointment->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                            Retour
                        </a>
                        @can('update', $appointment)
                            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline-primary">
                                Modifier
                            </a>
                        @endcan
                        @can('delete', $appointment)
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                Supprimer
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce rendez-vous ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
