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
            foreach ($response['articles'] as $post) {

                if ($postRepository->postExistsByExternalId($post['id'])) {
                    continue;
                }

                $postRepository->create([
                    'user_id' => $this->getSystemUser()->id,
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'published_at' => $post['publishedAt'],
                    'external_post_id' => $post['id']
                ]);
            }

            $this->info($response['count'] . " Blog posts polled successfully at " . now()->toDateTimeString());
            Log::info($response['count'] . " Blog posts polled successfully at " . now()->toDateTimeString());
        }

        return 0;
    }

    private function fetchBlogPostViaExternalApi() {
        try {
            $blogPostEndpoint = "https://candidate-test.sq1.io/api.php";
            $posts = Http::get($blogPostEndpoint)->json();

            return $posts;
        } catch (Exception $e) {
            Log::error("Blog posts could not be fetched", $e->getTrace());
        }
    }

    private function getSystemUser() {
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
    }
}
