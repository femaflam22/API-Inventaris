<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public function regis(array $data)
    {
        return User::create($data);
    }

    public function nonAktif($id)
    {
        $update = User::where('id', $id)->update(['status' => 0]);
        return User::find($id);
    }

    public function index()
    {
        return User::all();
    }

    public function checkStatus(array $data)
    {
        return User::where('username', $data['username'])->value('status');
    }
}
