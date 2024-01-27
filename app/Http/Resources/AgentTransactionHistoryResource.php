<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentTransactionHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "transaction_type" => $this->transaction_type,
            "amount" => $this->amount,
            "description" => $this->description,
            "created_at" => Carbon::parse($this->created_at)->format("d M, Y")
        ];
    }
}
