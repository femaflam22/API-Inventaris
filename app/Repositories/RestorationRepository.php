<?php
namespace App\Repositories;

use App\Models\Lending;
use App\Models\Restoration;

class RestorationRepository {
    public function index()
    {
        return Restoration::all();
    }

    public function checkTotalStuff(array $data)
    {
        $lending = Lending::find($data['lending_id']);
        $totalStuff = $lending->total_stuff;
        $totalRestoration = $data['total_good_stuff'] + $data['total_defec_stuff'];
        if ($totalRestoration > $totalStuff) {
            return response()->json([
                "status" => 400,
                "message" => "Jumlah barang LEBIH dari yang dipinjam!",
                "data" => []
            ], 400)->send();
            exit;
        } else if ($totalRestoration < $totalStuff) {
            return response()->json([
                "status" => 400,
                "message" => "Jumlah barang KURANG dari yang dipinjam!",
                "data" => []
            ], 400)->send();
            exit;
        } else {
            return NULL;
        }
    }

    public function store(array $data)
    {
        return Restoration::create($data);
    }
}
