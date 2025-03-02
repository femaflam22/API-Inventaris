<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        try {
            $payload = UserRequest::validate($request);
            $user = $this->userService->store($payload);
            // jika mengambil data gunakan ::collection, jika menambah/mengubah data gunakan new
            return response()->json([
                "status" => 200,
                "message" => "Berhasil membuat akun!",
                "data" => new UserResource($user)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $payload = UserLoginRequest::validate($request);
            $userStatus = $this->userService->checkStatus($payload);
            if ($userStatus) {
                $token = Auth::attempt($payload);
                if (!$token) {
                    return response()->json([
                        "status" => 400,
                        "message" => 'User not found',
                        "data" => []
                    ], 400);
                }
                $respondWithToken = [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'user' => auth()->user(),
                ];
                return response()->json([
                    "status" => 200,
                    "message" => "Berhasil login!",
                    "data" => $respondWithToken
                ], 200);
            } else {
                return response()->json([
                    "status" => 400,
                    "message" => "Tidak dapat melakukan proses login. User tidak aktif!"
                ], 400);
            }
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function me()
    {
        try {
            $user = Auth::user();
            return response()->json([
                "status" => 200,
                "message" => "Berhasil mengambil data identitas login!",
                "data" => $user
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                "status" => 200,
                "message" => 'berhasil logout!',
                "data" => []
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function nonAktif($userId)
    {
        try {
            $updatedData = $this->userService->nonAktif($userId);
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menonaktifkan akun!",
                "data" => new UserResource($updatedData)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }

    public function index()
    {
        try {
            $updatedData = $this->userService->index();
            return response()->json([
                "status" => 200,
                "message" => "Berhasil menampilkan seluruh data user!",
                "data" => UserResource::collection($updatedData)
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                "status" => 400,
                "message" => $err->getMessage()
            ], 400);
        }
    }
}
