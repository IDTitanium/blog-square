<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    const PAGE_SIZE = 20;
    /**
     * Get all post paginated
     * @return \App\Models\Post
     */
    public function getAllPostsPaginated() {
        return Post::sortable()->paginate(static::PAGE_SIZE);
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
            'published_at' => now()
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
}
