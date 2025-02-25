<?php
namespace App\Services;

use App\Repositories\InboundStuffRepository;
use Carbon\Carbon;

class InboundStuffService {
    private $inboundStuffRepository;
    public function __construct(InboundStuffRepository $inboundStuffRepository)
    {
        $this->inboundStuffRepository = $inboundStuffRepository;
    }

    public function index()
    {
        return $this->inboundStuffRepository->index();
    }

    public function store($data)
    {
        $path = null;
        if ($data->hasFile('proof_file')) {
            $path = $this->inboundStuffRepository->uploadImage($data->file('proof_file'));
        }
        $payload = [
            "stuff_id" => $data->stuff_id,
            "total" => $data->total,
            "date_time" => Carbon::now(),
            "proof_file" => $path,
        ];

        return $this->inboundStuffRepository->storeNewInbound($payload);
    }

    public function show ($id)
    {
        return $this->inboundStuffRepository->showInbound($id);
    }

    public function check ($id)
    {
        return $this->inboundStuffRepository->checkTotalInbound($id);
    }

    public function destroy($data)
    {
        $deleteImage = $this->inboundStuffRepository->deleteImage($data->proof_file);
        return $this->inboundStuffRepository->deleteInbound($data->id);
    }
}
