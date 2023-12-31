<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentStakeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->platform_ref,
//            "winningTags" => $this->winningTags->name,
            "stakePrice" => $this->stake_price,
            "ticketId" => $this->ticket_id,
            "number_picked" => $this->stake_number,
            "startDate" => Carbon::parse($this->start_date)->format("d M, Y"),
            "endDate" => Carbon::parse($this->end_date)->format("d M, Y"),
        ];
    }
}
