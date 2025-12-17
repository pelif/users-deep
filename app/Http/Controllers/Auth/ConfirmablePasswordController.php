<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\Contracts\ConfirmablePasswordServiceInterface;

class ConfirmablePasswordController extends Controller
{
    public function __construct(
        private ConfirmablePasswordServiceInterface $service,
    ) {}

    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->service->store($request);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
