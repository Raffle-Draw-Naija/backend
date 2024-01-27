<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->profile->id,
            "email" => $this->profile->email,
            "first_name" => $this->profile->first_name,
            "last_name" => $this->profile->last_name,
            "username" => $this->username,
            "account_created" => $this->account_created,
            "wallet" => $this->profile->wallet
        ];
    }
}
