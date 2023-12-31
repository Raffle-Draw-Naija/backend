<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddFundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->customers->first_name,
            'last_name' => $this->customers->last_name,
            'amount' => $this->amount,
            'transaction_type' => $this->transaction_type,
            'transaction_date' => Carbon::parse($this->created_at)->format("d M, Y")

        ];
    }
}
