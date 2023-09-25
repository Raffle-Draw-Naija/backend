<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WinningTageResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * name of the customer,
*stake price,
*winning tag,
*category,
*date,
*ticket id
*win

     */
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