<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StuffStockResource extends JsonResource {
    public function toArray($request)
    {
        $this->stuff->makeHidden('stuffStock');
        return [
            "id" => $this->id,
            "stuff" => $this->stuff,
            "stuff_stock" => $this->stuff->stuffStock,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
