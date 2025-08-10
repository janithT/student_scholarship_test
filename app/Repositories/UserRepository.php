<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    /**
     * Create user 
     * 
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * find user by email
     * 
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}