<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketTimeEntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'date_to'=> Carbon::parse($this->date_to)->format('d/m/Y H:m:s'),
            'employee' => $this->employee->first_name . ' '. $this->employee->last_name,
            'note'=> $this->note
        ];
    }
}
