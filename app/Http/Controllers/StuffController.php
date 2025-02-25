<?php

namespace App\Http\Controllers;

use App\Http\Requests\StuffRequest;
use App\Http\Resources\StuffResource;
use App\Services\StuffService;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    private $stuffService;
    public function __construct(StuffService $stuffService)
    {
        $this->stuffService = $stuffService;
    }

    public function index()
    {
        try {
            $stuffs = $this->stuffService->index();
            // response()->json : hasil yg akan dimunculkan ketika mengakses url terkait : json(dataygmaudimunculin, httpstatuscode)
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menampilkan seluruh data barang!",
                "data" => StuffResource::collection($stuffs)
            ], 200);
        } catch (\Exception $err) {
            // jika try ada yg error, munculkan response berupa desk err dan statusnya 400
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function store (Request $request)
    {
        try {
            $payload = StuffRequest::validate($request);
            $stuff = $this->stuffService->store($payload);
            // jika mengambil data gunakan ::collection, jika menambah/mengubah data gunakan new
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menambahkan data barang baru!",
                "data" => new StuffResource($stuff)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function update (Request $request, $id)
    {
        try {
            $payload = StuffRequest::validate($request);
            $stuff = $this->stuffService->update($payload, $id);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil mengubah data barang!",
                "data" => new StuffResource($stuff)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $stuffs = $this->stuffService->show($id);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menampilkan data detail barang!",
                "data" => new StuffResource($stuffs)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $stuffs = $this->stuffService->destroy($id);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menghapus barang!",
                "data" => []
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function trash()
    {
        try {
            $stuffs = $this->stuffService->trash();
            return response()->json([
                "status" => 200,
                "message" => "Berhasil mengambil data sampah!",
                "data" => StuffResource::collection($stuffs)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function restore($id)
    {
        try {
            $stuff = $this->stuffService->restore($id);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil mengambalikan data terhapus!",
                "data" => new StuffResource($stuff)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function permanentDelete($id)
    {
        try {
            $delete = $this->stuffService->permanentDelete($id);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menghapus barang secara permanen!",
                "data" => []
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }
}
