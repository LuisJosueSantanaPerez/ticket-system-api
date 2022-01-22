<?php

namespace App\Http\Controllers\Api\V1\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketCollection;
use App\Http\Resources\V1\TicketResource;
use App\Models\Employee;
use App\Models\TimeEntry;
use App\Models\Ticket;
use App\Models\TrackingTicketEmployee;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return TicketCollection|Application|ResponseFactory|AnonymousResourceCollection|Response
     */
    public function index(Request $request)
    {
        return new TicketCollection(
            Ticket::where('title', 'like', '%' . $request->get('q') . '%')
                ->paginate(
                    (int)$request->get('per_page')
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTicketRequest $request
     * @return Response
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::create([
                'date' => $request->date,
                'title' => $request->title,
                'kind_id'=> $request->kind_id,
                'category_id' => $request->category_id,
                'priority_id'=> $request->priority_id,
                'status_id'=> $request->status_id,
                "employee_id"=> $request->user()->id,
                "description" => $request->description
            ]);
            $ticket->employees()->attach($request->employees);
            DB::commit();
            return $this->success('Success', null, 'tickets',201);
        } catch (Exception $e){
            DB::rollBack();
            return $this->failure("failure => $e", 'tickets');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return TicketResource|Application|ResponseFactory|Response
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
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
        try {
            DB::beginTransaction();
            $ticket->title = $request->title;
            $ticket->kind_id = $request->kind_id;
            $ticket->category_id = $request->category_id;
            $ticket->priority_id = $request->priority_id;
            $ticket->status_id = $request->status_id;
            $ticket->description = $request->description;
            $ticket->save();
            DB::commit();
            return $this->success('Success', null, 'tickets');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function destroy(Ticket $ticket)
    {
        try {
            DB::beginTransaction();
            $ticket->delete();
            DB::commit();
            return $this->success('Success', null , 'tickets',204);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), 'tickets');
        }
    }
}
