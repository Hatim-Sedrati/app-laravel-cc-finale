<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Medical Appointment Manager')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex" style="min-height: 100vh; background-color: #f8f9fa;">
        <!-- Sidebar -->
        <nav class="bg-dark text-white p-3" style="width: 250px; overflow-y: auto;">
            <div class="mb-4">
                <h5 class="fw-bold">🏥 Medical Manager</h5>
            </div>
            
            @auth
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('appointments.index') }}" class="nav-link {{ Route::is('appointments.*') ? 'active' : '' }}">
                            📅 Rendez-vous
                        </a>
                    </li>
                    @if(auth()->user()->isPatient())
                        <li class="nav-item mb-2">
                            <a href="{{ route('appointments.create') }}" class="nav-link">
                                + Nouveau RDV
                            </a>
                        </li>
                    @endif
                </ul>

                <hr>

                <div class="small">
                    <p class="mb-2"><strong>{{ auth()->user()->name }}</strong></p>
                    <p class="badge bg-{{ auth()->user()->isDoctor() ? 'success' : 'primary' }}">
                        {{ auth()->user()->isDoctor() ? 'Médecin' : 'Patient' }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                        Déconnexion
                    </button>
                </form>
            @endauth
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1 d-flex flex-column">
            <!-- Header -->
            <header class="bg-white border-bottom p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">@yield('header', 'Medical Appointment Manager')</h2>
                    <select class="form-select form-select-sm" style="width: 150px;" onchange="changeLocale(this.value)">
                        <option value="fr" {{ app()->getLocale() === 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                    </select>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow-1 p-4">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erreurs:</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-dark text-white text-center p-3 mt-auto">
                <small>&copy; 2024 Medical Appointment Manager - Projet Étudiant OFPPT</small>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const baseUrl = "{{ url('/') }}";
        const csrfToken = "{{ csrf_token() }}";

        function changeLocale(locale) {
            window.location.href = `${baseUrl}/locale/${locale}`;
        }
    </script>
</body>
</html>
