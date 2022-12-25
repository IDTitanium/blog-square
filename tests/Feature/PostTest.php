<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
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

    public function test_can_poll_blogposts_for_external_service()
    {
        Artisan::call('db:seed --class=AdminUserSeeder');

        Http::fake([
            'https://candidate-test.sq1.io/api.php' => Http::response($this->getMockBody(), 200)
        ]);

        Artisan::call('poll:blogpost');

        $adminUser = User::where('name', User::ADMIN)->first();

        $this->assertDatabaseHas('posts', [
            'user_id' => $adminUser->id,
            'title' => "Title 1"
        ]);

        $this->assertDatabaseHas('posts', [
            'user_id' => $adminUser->id,
            'title' => "Title 2"
        ]);
    }

    private function getMockBody()
    {
        return [
            "status" => "ok",
            "count" => 2,
            "articles" => [
                [
                    "id" => 1,
                    "title" => "Title 1",
                    "description" => "It's not too late for the U.S. to do something about it.",
                    "publishedAt" => "2022-08-31T09:45:01Z"
                ],
                [
                    "id" => 2,
                    "title" => "Title 2",
                    "description" => "There's consensus that the 'energy transition' will involve fossil fuels for a long time to come, 'otherwise civilization will crumble,' Tesla CEO Elon Musk said in Norway.",
                    "publishedAt" => "2022-08-31T09:45:01Z"
                ]
            ]
        ];
    }
}
