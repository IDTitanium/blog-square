<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUserByName($name) {
        return User::where('name', $name)->first();
    }

    public function createUser($data) {
        return User::create($data);
    }
}
