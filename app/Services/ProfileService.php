<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileDeleteRequest;
use App\Services\Contracts\ProfileServiceInterface;
use Illuminate\Support\Facades\Auth;

class ProfileService implements ProfileServiceInterface
{
    public function edit(Request $request): array
    {
        return [
            'user' => $request->user(),
        ];
    }

    public function update(ProfileUpdateRequest $request): bool
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        return $request->user()->save();
    }

    public function destroy(ProfileDeleteRequest $request): bool
    {
        $request->validated();
        $user = $request->user();

        Auth::logout();

        $deleted = $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $deleted;
    }
}
