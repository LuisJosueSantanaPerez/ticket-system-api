<?php

namespace App\Http\Resources\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class TicketCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => 'Success',
            'data' => $this->collection,
            'meta' => [
                'organization' => 'NTI'
            ],
            'type'=> 'tickets'
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
