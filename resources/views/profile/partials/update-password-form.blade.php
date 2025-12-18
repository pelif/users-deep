<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Senha') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Atualize sua senha.') }}
        </p>
    </header>

    @if (session('successPassword'))
    <div class="alert alert-success col-12 text-center p-1">{{ session('successPassword') }} </div>
    @endif

    @if (session('errorPassword'))
    <div class="alert alert-danger col-12 text-center p-1">{{ session('errorPassword') }} </div>
    @endif

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Senha atual')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Senha nova')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar senha nova')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Alterar Senha') }}</x-primary-button>
        </div>
    </form>
</section>