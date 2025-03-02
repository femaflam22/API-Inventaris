<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// resources : mengatur response data yg akan dihasilkan dari API ini

class UserResource extends JsonResource {
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email,
            "role" => $this->role,
            "status" => $this->status ? 'Aktif' : 'Non-Aktif',
            "password" => $this->password,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
