<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StakeResource extends JsonResource
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
            'customer_id' => $this->user_id,
            'ticket_id' => $this->ticket_id,
            'category' => $this->sub_cat_id,
            'month' => $this->month,
            'year' => $this->year,
            'win' => $this->win,
            'stake_price' => $this->stake_price,

        ];
    }
}