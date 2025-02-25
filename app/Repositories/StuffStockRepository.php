<?php

namespace App\Repositories;

use App\Models\Lending;
use App\Models\StuffStock;

class StuffStockRepository {
    public function update ($data)
    {
        $totalInbound = $data->total;
        $stuffStock = StuffStock::where('stuff_id', $data->stuff_id)->first();
        $totalAvailableBefore = $stuffStock ? $stuffStock['total_available'] : 0;
        $totalAvailable = $totalAvailableBefore + $totalInbound;
        $totalDefec = $stuffStock ? $stuffStock['total_defec'] : 0;
        StuffStock::updateOrCreate([
            "stuff_id" => $data['stuff_id']
        ], [
            "total_available" => $totalAvailable,
            "total_defec" => $totalDefec,
        ]);
        return StuffStock::where('stuff_id', $data['stuff_id'])->first();
    }

    public function minUpdate ($data)
    {
        $total = $data['total'] ?? $data['total_stuff'];
        $stuffStock = StuffStock::where('stuff_id', $data['stuff_id'])->first();
        $totalAvailable = $stuffStock['total_available'];
        StuffStock::where('stuff_id', $data['stuff_id'])->update([
            'total_available' => $totalAvailable - $total
        ]);
        return StuffStock::where('stuff_id', $data['stuff_id'])->first();
    }

    public function upStock(array $data)
    {
        $lending = Lending::where('id', $data['lending_id'])->first();
        $stuffStock = StuffStock::where('stuff_id', $lending['stuff_id'])->first();
        $totalAvailable = $stuffStock['total_available'];
        $totalDefec = $stuffStock['total_defec'];
        StuffStock::where('stuff_id', $lending['stuff_id'])->update([
            'total_available' => $totalAvailable + $data['total_good_stuff'],
            'total_defec' => $totalDefec + $data['total_defec_stuff']
        ]);
        return StuffStock::where('stuff_id', $lending['stuff_id'])->first();
    }
}
