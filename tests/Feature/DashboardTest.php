<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_dashboard_without_login()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect();
        $response->assertRedirectContains('login');
    }

    public function test_logged_in_user_can_view_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
    }
}
