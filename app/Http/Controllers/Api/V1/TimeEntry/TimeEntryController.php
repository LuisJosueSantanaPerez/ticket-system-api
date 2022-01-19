<?php

namespace App\Http\Controllers\Api\V1\TimeEntry;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TimeEntryResource;
use App\Models\TimeEntry;
use Illuminate\Http\Request;
use PHPUnit\Exception;
use Illuminate\Support\Facades\DB;

class TimeEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimeEntryRequest $request)
    {
        try {
            DB::beginTransaction();
            TimeEntry::create([
                'employee_id' => $request->employee_id,
                'ticket_id' => $request->ticket_id,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'note' => $request->note
            ]);
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
     * @param  \App\Models\TimeEntry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(TimeEntry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeEntry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeEntry $entry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeEntry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeEntry $entry)
    {
        //
    }
}
