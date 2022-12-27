<?php

namespace App\Console\Commands;

use App\DTOs\PostDTO;
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
        try {
            $response = $this->fetchBlogPostViaExternalApi() ?? [];

            if (isset($response['articles'])) {
                $postStored = $this->storePosts($response['articles'], $postRepository);
                if ($postStored) {
                    $this->info($response['count'] . " Blog posts polled successfully at " . now()->toDateTimeString());
                    Log::info($response['count'] . " Blog posts polled successfully at " . now()->toDateTimeString());
                }
            }

        } catch (Exception $e) {
            $this->info($e->getMessage());
            Log::error($e->getMessage(), $e->getTrace());

            return 1;
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
            $response = Http::get($blogPostEndpoint)->json();

            return $response;
        } catch (Exception $e) {
            $this->info("An error occured, ". $e->getMessage());
            Log::error("Blog posts could not be fetched, ".$e->getMessage(), $e->getTrace());
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
            Log::error("Admin user could not be retrieved, ". $e->getMessage(), $e->getTrace());
        }
    }

    /**
     * Store posts from response
     * @param mixed $response
     * @param mixed $postRepository
     * @return bool
     */
    private function storePosts($posts, $postRepository) {
        try {
            foreach ($posts as $post) {

                if ($postRepository->postExistsByExternalId($post['id'])) {
                    continue;
                }
                $admin = $this->getSystemUser();

                if (!$admin) return false;

                $postDto = new PostDTO($post);

                $postRepository->create([
                    'user_id' => $admin->id,
                    'title' => $postDto->title,
                    'description' => $postDto->description,
                    'published_at' => $postDto->publishedAt,
                    'external_post_id' => $postDto->id
                ]);
            }

            return true;
        } catch (Exception $e) {
            Log::error("Blog posts could not be stored, ".$e->getMessage(), $e->getTrace());
            return false;
        }
    }
}
