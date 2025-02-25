<?php

namespace App\Repositories;

use App\Models\InboundStuff;
use App\Models\StuffStock;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InboundStuffRepository {
    public function index()
    {
        return InboundStuff::all();
    }

    public function uploadImage($file)
    {
        // Str::random(5) generate random karakter sebanyak 5 karakter disambungkan dengan getClientOriginalName() nama asli file, Str::random() bertujuan untuk memberikan identitas unik pada nama file
        $imageName = Str::random(5) .  "_" . $file->getClientOriginalName();
        // Buat direktori jika belum ada
        $uploadPath = storage_path('app/public/images');
        if (!File::exists($uploadPath)) {
            // 0755 merupakan kode untuk memberi izin akses file didalam folder terkait
            File::makeDirectory($uploadPath, 0755, true);
        }
        // memindahkan file yg diupload ke storage
        $file->move($uploadPath, $imageName);
        // membuat symlink storage dengan public agar gambar yg diupload ini dapat diakses secara public
        $publicStoragePath = base_path('public/storage');
        if (!File::exists($publicStoragePath)) {
            File::link(storage_path('app/public'), $publicStoragePath);
        }
        // membuat link untuk mengakses gambar
        $imageLink = env('APP_URL') . '/storage/images/' . $imageName;
        return $imageLink;
    }

    public function storeNewInbound(array $data)
    {
        return InboundStuff::create($data);
    }

    public function showInbound($id)
    {
        return InboundStuff::find($id);
    }

    public function deleteImage($file)
    {
        // Tentukan path lengkap dari gambar yang ingin dihapus
        $imagePath = storage_path('app/public/images/' . $file);

        // Periksa apakah file tersebut ada
        if (File::exists($imagePath)) {
            // Hapus file
            File::delete($imagePath);
        }
        return NULL;
    }

    public function checkTotalInbound($id)
    {
        $inboundStuff = InboundStuff::find($id);
        $stuffStock = StuffStock::where('stuff_id', $inboundStuff['stuff_id'])->first();
        if ($inboundStuff['total'] > $stuffStock['total_available']) {
            return response()->json([
                "status" => 400,
                "message" => "Total inbound tidak boleh lebih besar dari total stock",
                "data" => []
            ], 400)->send();
            exit;
        }
        return NULL;
    }

    public function deleteInbound($id)
    {
        return InboundStuff::where('id', $id)->delete();
    }
}
