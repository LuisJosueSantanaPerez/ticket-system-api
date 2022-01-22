<?php

namespace App\Http\Resources\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class StatusCollection extends ResourceCollection
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
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => (int)$this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage()
            ],
            'meta' => [
                'organization' => 'NTI'
            ],
            'type'=> 'statuses'
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset(
            $jsonResponse['links'],
            $jsonResponse['meta']['current_page'],
            $jsonResponse['meta']['links'],
            $jsonResponse['meta']['from'],
            $jsonResponse['meta']['last_page'],
            $jsonResponse['meta']['per_page'],
            $jsonResponse['meta']['to'],
            $jsonResponse['meta']['total'],
            $jsonResponse['meta']['path'],
        );
        $response->setContent(json_encode($jsonResponse));
    }
}
