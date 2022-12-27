<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PollBlogPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poll:blogpost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This polls the external blog post endpoint.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(PostRepository $postRepository)
    {
        $response = $this->fetchBlogPostViaExternalApi() ?? [];

        if (isset($response['articles'])) {
            $postStored = $this->storePosts($response, $postRepository);
            if ($postStored) {
                $this->info($response['count'] . " Blog posts polled successfully at " . now()->toDateTimeString());
                Log::info($response['count'] . " Blog posts polled successfully at " . now()->toDateTimeString());
            }
        }

        return 0;
    }

    /**
     * Fetch posts via external api
     * @return mixed
     */
    private function fetchBlogPostViaExternalApi() {
        try {
            $blogPostEndpoint = config('blogconfig.feed_server_api');
            $posts = Http::get($blogPostEndpoint)->json();

            return $posts;
        } catch (Exception $e) {
            Log::error("Blog posts could not be fetched", $e->getTrace());
        }
    }

    /**
     * Get system user for posts
     * @return mixed
     */
    private function getSystemUser() {
        try {
            $userRepository = app()->make(UserRepository::class);
            $adminUser = $userRepository->getUserByName(User::ADMIN);

            if (!$adminUser) {
                $adminUser = $userRepository->createUser([
                    'name' => User::ADMIN,
                    'email' => User::ADMIN_EMAIL,
                    'password' => Hash::make('password')
                ]);
            }

            return $adminUser;
        } catch (Exception $e) {
            Log::error("Admin user could not be retrieved", $e->getTrace());
        }
    }

    /**
     * Store posts from response
     * @param mixed $response
     * @param mixed $postRepository
     * @return bool
     */
    private function storePosts($response, $postRepository) {
        try {
            foreach ($response['articles'] as $post) {

                if ($postRepository->postExistsByExternalId($post['id'])) {
                    continue;
                }
                $admin = $this->getSystemUser();

                if (!$admin) return false;

                $postRepository->create([
                    'user_id' => $admin->id,
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'published_at' => $post['publishedAt'],
                    'external_post_id' => $post['id']
                ]);
            }

            return true;
        } catch (Exception $e) {
            Log::error("Blog posts could not be stored", $e->getTrace());
            return false;
        }
    }
}
