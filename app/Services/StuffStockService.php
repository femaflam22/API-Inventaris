<?php
namespace App\Services;

use App\Repositories\StuffStockRepository;

class StuffStockService {
    private $stuffStockRepository;
    public function __construct(StuffStockRepository $stuffStockRepository)
    {
        $this->stuffStockRepository = $stuffStockRepository;
    }

    public function update ($data)
    {
        return $this->stuffStockRepository->update($data);
    }

    public function minUpdate ($data)
    {
        return $this->stuffStockRepository->minUpdate($data);
    }

    public function upStock(array $data)
    {
        return $this->stuffStockRepository->upStock($data);
    }
}
