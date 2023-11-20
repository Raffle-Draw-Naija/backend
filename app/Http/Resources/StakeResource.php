<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class StakeResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'category' => $this->category_name,
            'month' => $this->month,
            'year' => $this->year,
            'win' => $this->win,
            'winningTags' => $this->name,
            'stakePrice' => $this->stake_price,
            'ticketId' => $this->ticket_id,
            'date' => Carbon::parse($this->created_at)->format("d M, Y") ,
            'numberPicked' => $this->stake_number,
            'payment_method' => $this->payment_method,
            'stake_platform_id' => $this->stake_platform_id,
        ];
    }
}
