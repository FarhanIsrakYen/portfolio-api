<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'address' => $this->address,
            'website' => $this->website,
            'dob' => $this->dob,
            'objective' => $this->objective,
            'interests' => $this->interests,
            'photo' => $this->username . '.jpeg',
            'secret_key' => $this->secret_key
        ];
    }
}
