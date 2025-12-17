<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileDeleteRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\Contracts\ProfileServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{


    public function __construct(
        private ProfileServiceInterface $service
    ) {}


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', $this->service->edit($request));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $userUpdated = $this->service->update($request);

        if ($userUpdated)
            return Redirect::route('profile.edit')->with('message', 'Usuário alterado com sucesso!');

        return Redirect::route('profile.edit')->with('error', 'Erro ao alterar usuário');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(ProfileDeleteRequest $request): RedirectResponse
    {
        $deleted = $this->service->destroy($request);

        if ($deleted)
            return Redirect::route('profile.edit')->with('message', 'Usuário excluído com sucesso!');

        return Redirect::route('profile.edit')->with('error', 'Erro ao excluir usuário');
    }

    /**
     * Upload the user's avatar.
     */
    public function uploadAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = $request->user();

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('message', 'Avatar alterado com sucesso!');
    }
}
