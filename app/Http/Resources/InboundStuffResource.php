<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InboundStuffResource extends JsonResource {
    public function toArray($request)
    {
        $this->stuff->makeHidden('stuffStock');
        return [
            "id" => $this->id,
            "stuff" => $this->stuff,
            "stuff_stock" => $this->stuff->stuffStock,
            "total" => $this->total,
            "proof_file" => $this->proof_file,
            "date_time" => $this->date_time,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
