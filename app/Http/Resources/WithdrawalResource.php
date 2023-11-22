<?php

namespace App\Http\Resources;

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
            "account_number" => $this->bankAccount->account_no,
            "account_name" => $this->bankAccount->account_name,
            "bank" => $this->bankAccount->bank,
            "status" => $this->status
        ];
    }
}
