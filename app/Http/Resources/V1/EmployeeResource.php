<?php

namespace App\Http\Resources\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use Carbon\Carbon;

class EmployeeResource extends JsonResource
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
            'id' => $this->id,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'code' => $this->number,
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'email' => $this->email,
            'activated' => $this->activated
        ];
    }
}
