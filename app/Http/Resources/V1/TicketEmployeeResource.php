<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'ticket_number' => $this->number,
            'date' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'title' => $this->title,
            'description' => $this->description,
            'created_by' =>  $this->employee->first_name .' '. $this->employee->last_name,
            'kind' => [
                'id' => $this->kind->id,
                'name' => $this->kind->name
            ],
            'category' => [
                'id' => $this->category->id,
                'name'=> $this->category->name
            ],
            'priority' => [
                'id' => $this->priority->id,
                'name' => $this->priority->name
            ],
            'status' => [
                'id' => $this->status->id,
                "name" =>$this->status->name
            ],
            'employees' => EmployeeResource::collection($this->employees)
        ];
    }
}
