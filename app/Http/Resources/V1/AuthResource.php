<?php

namespace App\Http\Resources\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => 'Success',
            'data' => [
                'id' => $this->number,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'token' => $request->user()->createToken($request->device)->plainTextToken,
            ],
            'meta' => [
                'organization' => 'NTI'
            ],
            'type'=> 'login',
        ];
    }
}
