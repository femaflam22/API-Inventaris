<?php

namespace App\Services;

use App\Repositories\StuffRepository;
// memisahkan business logic dengan controller. proses manipulasi hasil dari Repository

class StuffService {
    private $stuffRepository;
    public function __construct(StuffRepository $stuffRepository)
    {
        // proses panggil file repository
        $this->stuffRepository = $stuffRepository;
    }

    public function index()
    {
        return $this->stuffRepository->getAllStuff();
    }

    public function show($id)
    {
        return $this->stuffRepository->getSpecificStuff($id);
    }

    public function store(array $data)
    {
        return $this->stuffRepository->storeNewStuff($data);
    }

    public function update(array $data, $id)
    {
        return $this->stuffRepository->updateStuff($data, $id);
    }

    public function destroy($id)
    {
        return $this->stuffRepository->deleteStuff($id);
    }

    public function trash()
    {
        return $this->stuffRepository->getTrash();
    }

    public function restore($id)
    {
        return $this->stuffRepository->restoreTrash($id);
    }

    public function permanentDelete($id)
    {
        return $this->stuffRepository->permanentDeleteTrash($id);
    }
}
