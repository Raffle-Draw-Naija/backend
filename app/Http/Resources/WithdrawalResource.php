<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->customer->first_name . " " . $this->customer->last_name,
            "amount" => $this->amount,
            "id" => $this->id,
            "account_number" => $this->account_number,
            "account_name" => $this->account_name,
            "bank" => $this->bank_name,
            "status" => $this->status,
            "created_date" => Carbon::parse($this->created_at)->format("d M, Y")
        ];
    }
}
