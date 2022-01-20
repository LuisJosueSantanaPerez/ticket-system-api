<?php

namespace App\Http\Resources\V1;

use Illuminate\Contracts\Support\Arrayable as ArrayableAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|ArrayableAlias|JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'number' => $this->number,
            'first_name' => $this->first_name,
            'last_name' => $this->first_name,
            'email' => $this->email,
            'tickets' => TicketResource::collection($this->tickets)
        ];
    }
}
