<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

// resources : mengatur response data yg akan dihasilkan dari API ini

class StuffResource extends JsonResource {
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "type" => strtoupper($this->type),
            "stuff_stock" => $this->stuffStock,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
