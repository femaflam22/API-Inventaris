<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public function regis(array $data)
    {
        return User::create($data);
    }
}
