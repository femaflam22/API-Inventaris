<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService {
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->regis($data);
    }

    public function nonAktif($id)
    {
        return $this->userRepository->nonAktif($id);
    }

    public function index()
    {
        return $this->userRepository->index();
    }

    public function checkStatus(array $data)
    {
        return $this->userRepository->checkStatus($data);
    }
}
