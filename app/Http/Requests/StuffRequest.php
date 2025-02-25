<?php

namespace App\Http\Requests;

use App\Models\Stuff;
use Illuminate\Validation\Factory;
use Illuminate\Http\Request;

class StuffRequest
{
    // menggunakan static agar pemanggilan menggunakan :: tanpa perlu new
    public static function validate(Request $request)
    {
        // validasi in: agar data yg diisi hanya diantara item array tersebut saja, selain dari itu gabisa
        $rules = [
            'name' => 'required|min:3',
            'type' => 'required|in:' . implode(',', [Stuff::HTL_KLN, Stuff::LAB, Stuff::SARPRAS]),
        ];
        // lumen hanya bisa validasi bentuk $this->validate($request, [....]) tp $this hanya bisa di panggil di controller, tempat awal. jd solusinya gunakan Factory dari Validation
        $validator = app(Factory::class)->make($request->all(), $rules);
        // jika validasi ada error, langsung kirim json dan exit, kodingan lainnya (di controller) tdk dijalankan
        if ($validator->fails()) {
            response()->json([
                "status" => 400,
                "message" => "Data yang dimasukkan tidak sesuai!",
                "data" => $validator->errors()
            ], 400)->send();
            exit;
        } else { //jika tdk ada yg gagal validasinya, kirim hasil data yg sudah divalidasi
            return $validator->validated();
        }
    }
}
