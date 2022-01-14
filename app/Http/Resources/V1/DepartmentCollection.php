<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\DepartmentResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class DepartmentCollection extends ResourceCollection
{
    // public $collects = DepartmentResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
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
            'type'=> 'departments',
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => (int)$this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage()
            ]
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
        );
        $response->setContent(json_encode($jsonResponse));
    }
}
