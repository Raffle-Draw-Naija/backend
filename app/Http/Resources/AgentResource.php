<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            "firstName" => $this->agents[0]->first_name,
            "lastName" => $this->agents[0]->last_name,
            "phone" => $this->agents[0]->phone,
            "address" => $this->agents[0]->address,
            "balance" => $this->agents[0]->wallet,
            "agent_id" => $this->agents[0]->id,
            "verified" => $this->verified,
            "identity" => $this->identity
        ];
    }
}
