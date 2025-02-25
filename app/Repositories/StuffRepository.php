<?php

namespace App\Repositories;

use App\Models\Stuff;

// repositories : memisahkan logika data dengan controller, jd isinya berupa ORM/eloquent dengan model yg diperlukan controller

class StuffRepository {
    public function getAllStuff()
    {
        // mengambil semua data dengan pagination
        return Stuff::paginate(10);
    }

    public function getSpecificStuff($id)
    {
        return Stuff::find($id);
    }

    public function storeNewStuff(array $data)
    {
        return Stuff::create($data);
    }

    public function updateStuff(array $data, $id) {
        // update dulu datanya
        Stuff::where('id', $id)->update($data);
        // yg dikembalikan hasil pencarian dr data yg baru diupdate tsb
        return Stuff::find($id);
    }

    public function deleteStuff($id)
    {
        return Stuff::where('id', $id)->delete();
    }

    public function getTrash()
    {
        return Stuff::onlyTrashed()->get();
    }

    public function restoreTrash($id)
    {
        $restore = Stuff::onlyTrashed()->where('id', $id)->restore();
        return Stuff::find($id);
    }

    public function permanentDeleteTrash($id)
    {
        $delete = Stuff::onlyTrashed()->where('id', $id)->forceDelete();
        return NULL;
    }
}
