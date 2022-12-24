<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_can_be_rendered()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_validation_errors_if_post_is_created_with_incomplete_details() {
        $response = $this->post('/posts', [
            'title' => null
        ]);

        $response->assertSessionHasErrors();
        $response->assertRedirect();
    }

    public function test_can_create_post() {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->post('/posts', [
            'title' => "A new post",
            'description' => "A stich in time saves nine"
        ]);

        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('posts', [
            'title' => "A new post",
            'user_id' => $user->id
        ]);
    }

    public function test_can_view_all_created_posts()
    {
        User::factory()->create();

        //Create post
        Post::factory()->create();

        $response = $this->get('/');

        $response->assertViewHas('posts', Post::paginate(20));
    }

    public function test_logged_in_user_can_view_posts_created_by_them()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        Post::factory()->create();

        $response = $this->get('/dashboard');

        $response->assertStatus(200);

        $response->assertViewHas('posts', Post::where('user_id', $user->id)->paginate(20));
    }
}
