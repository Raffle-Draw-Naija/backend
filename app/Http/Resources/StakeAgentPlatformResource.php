<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StakeAgentPlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
//            "winningTags" => $this->winning_tags->name,
            "stakePrice" => $this->stake_price,
            "startDate" => Carbon::parse($this->start_date)->format("d M, Y"),
            "endDate" => Carbon::parse($this->end_date)->format("d M, Y"),
        ];
    }
}
