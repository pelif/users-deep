<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use App\Models\User;
use App\Services\Contracts\NewPasswordServiceInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{

    public function __construct(
        private NewPasswordServiceInterface $service,
    ) {}

    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $request): RedirectResponse
    {
        $request->validated();
        $reseted = $this->service->store($request);

        if ($reseted) {
            return redirect()
                ->route('login')
                ->with('message', 'Senha alterada com sucesso!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors('error', 'Erro ao alterar senha!');
    }
}
