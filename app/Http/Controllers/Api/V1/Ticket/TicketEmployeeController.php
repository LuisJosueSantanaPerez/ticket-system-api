<?php

namespace App\Http\Controllers\Api\V1\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketEmployeeCollection;
use App\Http\Resources\V1\TicketEmployeeResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TicketEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TicketEmployeeCollection
     */
    public function index(Request $request)
    {

        return new TicketEmployeeCollection(
            Ticket::with("employees" )
                ->where('title', 'like', '%' . $request->get('q') . '%')
                ->paginate(
                    (int)$request->get('per_page')
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return TicketEmployeeResource
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return TicketEmployeeResource|Builder[]|Collection
     */
    public function show($id)
    {
        return new TicketEmployeeResource(Ticket::with("employees")->find((int)$id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
