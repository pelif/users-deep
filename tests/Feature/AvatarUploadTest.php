<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_avatar_can_be_uploaded(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this
            ->actingAs($user)
            ->post('/profile/avatar', [
                'avatar' => $file,
            ]);

        $response
            ->assertSessionHas('status', 'avatar-updated')
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
    }

    public function test_old_avatar_is_deleted_when_new_one_is_uploaded(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $oldAvatar = UploadedFile::fake()->image('old_avatar.jpg');
        $newAvatar = UploadedFile::fake()->image('new_avatar.jpg');

        // First upload
        $this->actingAs($user)->post('/profile/avatar', ['avatar' => $oldAvatar]);
        $oldPath = $user->fresh()->avatar;

        // Second upload
        $this->actingAs($user)->post('/profile/avatar', ['avatar' => $newAvatar]);
        $newPath = $user->fresh()->avatar;

        Storage::disk('public')->assertExists($newPath);
        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_avatar_must_be_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this
            ->actingAs($user)
            ->post('/profile/avatar', [
                'avatar' => $file,
            ]);

        $response->assertSessionHasErrors('avatar');
    }

    public function test_avatar_upload_fails_for_large_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('large_avatar.jpg')->size(3000); // 3MB

        $response = $this
            ->actingAs($user)
            ->post('/profile/avatar', [
                'avatar' => $file,
            ]);

        $response->assertSessionHasErrors('avatar');
    }
}
