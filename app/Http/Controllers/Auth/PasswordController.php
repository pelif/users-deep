<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Services\Contracts\PasswordServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function __construct(
        private PasswordServiceInterface $service
    ) {}

    /**
     * Update the user's password.
     */
    public function update(PasswordRequest $request): RedirectResponse
    {
        $updated = $this->service->update($request->validated());

        if (!$updated) {
            return back()->withErrors([
                'current_password' => 'Senha atual inválida',
            ]);
        }

        return back()->with('message', 'Senha atualizada com sucesso');
    }
}
