<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * @property int $id
     * @property string $name
     * @property string $last_name
     * @property string $email
     * @property string $phone
     * @property bool $phone_verified
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => [
                'number' => $this->phone,
                'verified' => $this->phone_verified,
            ],
            'name' => [
                'first' => $this->name,
                'last' => $this->last_name,
            ],
        ];
    }
}
