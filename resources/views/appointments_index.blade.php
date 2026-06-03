@extends('app')

@section('header', 'Rendez-vous')
@section('title', 'Rendez-vous - Medical Appointment Manager')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Liste des Rendez-vous</h3>
        @if(auth()->user()->isPatient())
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                + Nouveau Rendez-vous
            </a>
        @endif
    </div>

    <!-- Search Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                </div>
                <div class="col-md-4">
                    <select id="statusFilter" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="pending">En attente</option>
                        <option value="confirmed">Confirmé</option>
                        <option value="cancelled">Annulé</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="appointmentsTable">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>{{ auth()->user()->isDoctor() ? 'Patient' : 'Médecin' }}</th>
                        <th>Service</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->formatted_date }}</td>
                            <td>
                                {{ auth()->user()->isDoctor() 
                                    ? $appointment->patient->name 
                                    : $appointment->doctor->name }}
                            </td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ number_format($appointment->service->price, 2, ',', ' ') }} €</td>
                            <td>
                                <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ $appointment->status_label }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                                @can('update', $appointment)
                                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-secondary">
                                        Modifier
                                    </a>
                                @endcan
                                @can('delete', $appointment)
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $appointment->id }}">
                                        Supprimer
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $appointment->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer ce rendez-vous ?
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
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucun rendez-vous trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
