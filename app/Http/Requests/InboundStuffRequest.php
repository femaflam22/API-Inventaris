<?php

namespace App\Http\Requests;

use Illuminate\Validation\Factory;
use Illuminate\Http\Request;

class InboundStuffRequest
{
    public static function validate(Request $request)
    {
        $rules = [
            'stuff_id' => 'required',
            'total' => 'required',
            'proof_file' => 'required|image|max:2048',
        ];
        $validator = app(Factory::class)->make($request->all(), $rules);
        if ($validator->fails()) {
            response()->json([
                "status" => 400,
                "message" => "Data yang dimasukkan tidak sesuai!",
                "data" => $validator->errors()
            ], 400)->send();
            exit;
        } else {
            return $validator->validated();
        }
    }
}
