<?php

namespace App\Http\Controllers;

use App\Http\Requests\InboundStuffRequest;
use App\Http\Resources\InboundStuffResource;
use App\Http\Resources\StuffStockResource;
use App\Services\InboundStuffService;
use App\Services\StuffStockService;
use Illuminate\Http\Request;

class InboundStuffController extends Controller
{
    private $inboundStuffService, $stuffStockService;
    public function __construct(InboundStuffService $inboundStuffService, StuffStockService $stuffStockService)
    {
        $this->inboundStuffService = $inboundStuffService;
        $this->stuffStockService = $stuffStockService;
    }

    public function index()
    {
        try {
            $inboundStuffs = $this->inboundStuffService->index();
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menampilkan seluruh data pemasukan barang!",
                "data" => InboundStuffResource::collection($inboundStuffs)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function store (Request $request)
    {
        try {
            $payload = InboundStuffRequest::validate($request);
            $inboundStuff = $this->inboundStuffService->store($request);
            $stuffStock = $this->stuffStockService->update($inboundStuff);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menambahkan data pemasukan barang!",
                "data" => new InboundStuffResource($inboundStuff)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function destroy ($id)
    {
        try {
            $checkTotalInbound = $this->inboundStuffService->check($id);
            if (is_null($checkTotalInbound)) {
                $inboundStuff = $this->inboundStuffService->show($id);
                $delete = $this->inboundStuffService->destroy($inboundStuff);
                $stuffStock = $this->stuffStockService->minUpdate($inboundStuff);
                return response()->json([
                    "status" => 200,
                    "message" => "Berhasil menghapus data pemasukan barang!",
                    "data" => new StuffStockResource($stuffStock)
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
