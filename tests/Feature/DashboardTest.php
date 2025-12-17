<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use DatabaseTransactions;

    public function test_dashboard_page_is_displayed_for_authenticated_users()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Bem-vindo, ' . $user->name);
        $response->assertSee($user->email);
        $response->assertSee('Editar Perfil');
        $response->assertSee('Logout');
    }

    public function test_dashboard_redirects_unauthenticated_users_to_login()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}
