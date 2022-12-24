<?php

namespace App\Repositories;

class DashboardRepository
{
    /**
     * Prepare data required to be displayed on dashboard
     * @return array
     */
    public function prepareData() {
        $loggedInUserPosts = app()->make(PostRepository::class)->getUserPosts();

        return [
            'posts' => $loggedInUserPosts
        ];
    }
}
