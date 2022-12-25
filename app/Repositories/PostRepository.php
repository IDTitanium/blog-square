<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostRepository
{
    const PAGE_SIZE = 20;
    const CACHE_TTL = 60;
    /**
     * Get all post paginated
     * @return \App\Models\Post
     */
    public function getAllPostsPaginated() {
        $key = Post::getCacheKey();

        return Cache::remember($key, static::CACHE_TTL, function () {
            return Post::sortable()->paginate(static::PAGE_SIZE);
        });
    }

    /**
     * Create a new post
     * @param mixed $data
     * @return \App\Models\Post
     */
    public function create($data) {
        return Post::create([
            'user_id' => $data['user_id'] ?? auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'],
            'published_at' => $data['published_at'] ?? now(),
            'external_post_id' => $data['external_post_id'] ?? null
        ]);
    }

    /**
     * Get all posts for logged in user
     * @return mixed
     */
    public function getUserPosts() {
        return Post::sortable()
                ->where('user_id', auth()->id())
                ->paginate(static::PAGE_SIZE);
    }

    /**
     * Check existence of a post by its external_post_id
     * @param int $externalId
     * @return bool
     */
    public function postExistsByExternalId($externalId) {
        return Post::where('external_post_id', $externalId)->exists();
    }
}
