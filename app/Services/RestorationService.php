<?php
namespace App\Services;

use App\Repositories\RestorationRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RestorationService {
    private $restorationRepository;
    public function __construct(RestorationRepository $restorationRepository)
    {
        $this->restorationRepository = $restorationRepository;
    }

    public function index()
    {
        return $this->restorationRepository->index();
    }

    public function checkTotalStuff(array $data)
    {
        return $this->restorationRepository->checkTotalStuff($data);
    }

    public function store(array $data)
    {
        $payload = [
            "user_id" => Auth::user()->id,
            "lending_id" => $data['lending_id'],
            "date_time" => Carbon::now(),
            "total_good_stuff" => $data['total_good_stuff'],
            "total_defec_stuff" => $data['total_defec_stuff'],
        ];
        return $this->restorationRepository->store($payload);
    }
}
