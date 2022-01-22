<?php

namespace App\Http\Controllers\Api\V1\TimeEntry;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTimeEntryRequest;
use App\Http\Resources\V1\TimeEntryCollection;
use App\Http\Resources\V1\TimeEntryResource;
use App\Models\TimeEntry;
use App\Models\TimeEntryTicket;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class TimeEntryController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return TimeEntryCollection
     */
    public function index(Request $request)
    {

        return new TimeEntryCollection(TimeEntry::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTimeEntryRequest $request
     * @return Response
     */
    public function store(StoreTimeEntryRequest $request)
    {
        try {
            DB::beginTransaction();

            $timeEntry = TimeEntry::create([
                'employee_id' => $request->employee_id,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'note' => $request->note
            ]);

            $timeEntry->tickets()->attach($request->ticket_id);

            DB::commit();
            return $this->success('Success', null, 'statuses',201);
        } catch (Exception $e){
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param TimeEntry $timeEntry
     * @return TimeEntryResource
     */
    public function show(TimeEntry $timeEntry)
    {
        return new TimeEntryResource($timeEntry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TimeEntry $timeEntry
     * @return Response
     */
    public function update(Request $request, TimeEntry $timeEntry)
    {
        try {
            DB::beginTransaction();
            $timeEntry->employee_id = $request->employee_id;
            $timeEntry->date_from = $request->date_from;
            $timeEntry->date_to = $request->date_to;
            $timeEntry->note = $request->note;
            $timeEntry->save();
            return $this->success('Success', null, 'tickets');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TimeEntry $timeEntry
     * @return Response
     */
    public function destroy(TimeEntry $timeEntry)
    {
        try {
            DB::beginTransaction();
            $timeEntry->delete();
            DB::commit();
            return $this->success('Success', null , 'time-entry',204);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), 'time-entry');
        }
    }
}
