<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esqueceu sua senha? Sem problema. Apenas nos diga seu endereço de e-mail e enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="d-flex flex-column justify-content-between align- items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar link de redefinição de senha') }}
            </x-primary-button>

            <a class="text-decoration-none text-muted small mt-4" href="{{ route('login') }}">
                {{ __('Já possui uma conta?') }}
            </a>

            <a class="text-decoration-none text-muted small mt-2" href="{{ route('register') }}">
                {{ __('Não possui uma conta?') }}
            </a>
        </div>
    </form>
</x-guest-layout>