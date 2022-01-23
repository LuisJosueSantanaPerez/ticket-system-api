<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TimeEntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $dateForm = Carbon::parse($this->date_from);
        $dateTo = Carbon::parse($this->date_to);
        // $totalDuration = $dateTo->diff($dateForm)->format('%H:%i:%s');
        $totalDuration = $dateTo->diffInMinutes($dateForm, true);


        return [
            'id' => $this->id,
            'date_from' => Carbon::parse($this->date_from)->format('d/m/Y h:m:s g:i A'),
            'date_to' => Carbon::parse($this->date_to)->format('d/m/Y h:m:s g:i A'),
            'tickets' => TicketResource::collection($this->tickets),
            'time' => (float)number_format(($totalDuration / 60), 1),
            'employee' =>  [ // employee_id
                'id' => $this->employee->id,
                'first_name' =>$this->employee->first_name,
                'last_name' =>$this->employee->last_name,
                'email' => $this->employee->last_name,
            ],
            'note'=> $this->note
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset(
            $jsonResponse['links'],
            $jsonResponse['meta']['links'],
            $jsonResponse['meta']['from'],
            $jsonResponse['meta']['to'],
            $jsonResponse['meta']['path'],
        );
        $response->setContent(json_encode($jsonResponse));
    }
}
