<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Factory;
use Illuminate\Http\Request;

class UserRequest
{
    public static function validate(Request $request)
    {
        $request['role'] = $request->role ?? "staff";
        $rules = [
            'username' => 'required|min:5',
            'email' => 'required|email:dns',
            'password' => 'required',
            'role' => 'required|in:' . implode(',', [User::ADMIN, User::STAFF]),
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
