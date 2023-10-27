<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WinningTageResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'sub_cat_id' => $this->sub_cat_id,
            'stake_price' => $this->stake_price,
            'image' => $this->image,
        ];
    }
}
