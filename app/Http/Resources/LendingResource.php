<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LendingResource extends JsonResource {

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "stuff" => $this->stuff,
            "date_time" => $this->date_time,
            "name" => $this->name,
            "user" => $this->user,
            "notes" => $this->notes,
            "total_stuff" => $this->total_stuff,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
