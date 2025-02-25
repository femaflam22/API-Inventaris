<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\DatabasePresenceVerifier;

class UserLoginRequest
{
    public static function validate(Request $request)
    {
        $rules = [
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ];
        $validator = app(Factory::class)->make($request->all(), $rules);
        $validator->setPresenceVerifier(new DatabasePresenceVerifier(DB::getFacadeRoot()));
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
