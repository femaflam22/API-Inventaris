<?php
namespace App\Services;

use App\Repositories\LendingRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LendingService {
    private $lendingRepository;
    public function __construct(LendingRepository $lendingRepository)
    {
        $this->lendingRepository = $lendingRepository;
    }

    public function index()
    {
        return $this->lendingRepository->index();
    }

    public function check(array $data)
    {
        return $this->lendingRepository->checkStock($data);
    }

    public function store(array $data)
    {
        $payload = [
            "stuff_id" => $data['stuff_id'],
            "date_time" => Carbon::now(),
            "name" => $data['name'],
            "user_id" => Auth::user()->id,
            "notes" => $data['notes'] ?? NULL,
            "total_stuff" => $data['total_stuff']
        ];
        return $this->lendingRepository->store($payload);
    }
}
