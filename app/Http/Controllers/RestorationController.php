<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestorationRequest;
use App\Http\Resources\RestorationResource;
use App\Services\RestorationService;
use App\Services\StuffStockService;
use Illuminate\Http\Request;

class RestorationController extends Controller
{
    private $restorationService, $stuffStockService;
    public function __construct(RestorationService $restorationService, StuffStockService $stuffStockService)
    {
        $this->restorationService = $restorationService;
        $this->stuffStockService = $stuffStockService;
    }

    public function index()
    {
        try {
            $restorations = $this->restorationService->index();
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menampilkan seluruh data pengembalian barang!",
                "data" => RestorationResource::collection($restorations)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $payload = RestorationRequest::validate($request);
            $checkStuff = $this->restorationService->checkTotalStuff($payload);
            if (is_null($checkStuff)) {
                $restoration = $this->restorationService->store($payload);
                $stuffStock = $this->stuffStockService->upStock($payload);
                return response()->json([
                    "status" => 200,
                    "message" => "Berhasil menambahkan data pengembalian barang!",
                    "data" => new RestorationResource($restoration)
                ], 200);
            }
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }
}
