<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LendingRequest;
use App\Services\LendingService;
use App\Services\StuffStockService;
use App\Http\Resources\LendingResource;
class LendingController extends Controller
{
    private $lendingService, $stuffStockService;
    public function __construct(LendingService $lendingService, StuffStockService $stuffStockService)
    {
        $this->lendingService = $lendingService;
        $this->stuffStockService = $stuffStockService;
    }

    public function index()
    {
        try {
            $lendings = $this->lendingService->index();
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menampilkan seluruh data peminjaman!",
                "data" => LendingResource::collection($lendings)
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
            $payload = LendingRequest::validate($request);

            $checkStock = $this->lendingService->check($payload);
            if (is_null($checkStock)) {
                $lending = $this->lendingService->store($payload);
                $stuffStock = $this->stuffStockService->minUpdate($payload);
                return response()->json([
                    "status" => 200,
                    "message" => "Berhasil menambahkan data peminjaman!",
                    "data" => new LendingResource($lending)
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
