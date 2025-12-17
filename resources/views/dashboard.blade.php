<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <div class="card-header bg-white">
                            <h4 class="mb-0 fw-bold">Bem-vindo, {{ Auth::user()->name }}!</h4>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif

                            <h5 class="card-title">Suas Informações</h5>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item">
                                    <strong>Nome:</strong> {{ Auth::user()->name }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Email:</strong> {{ Auth::user()->email }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Membro desde:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}
                                </li>
                            </ul>

                            <div class="d-flex gap-2">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    Editar Perfil
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>