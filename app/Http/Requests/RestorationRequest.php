<?php

namespace App\Http\Requests;

use Illuminate\Validation\Factory;
use Illuminate\Http\Request;

class RestorationRequest
{
    public static function validate(Request $request)
    {
        $rules = [
            'lending_id' => 'required',
            'total_good_stuff' => 'required',
            'total_defec_stuff' => 'required',
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
            return $request->all();
        }
    }
}
