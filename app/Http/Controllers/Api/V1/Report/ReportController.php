<?php

namespace App\Http\Controllers\Api\V1\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\IndexReportRequest;
use App\Http\Resources\V1\TimeEntryCollection;
use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TimeEntryCollection
     */
    public function index(IndexReportRequest $request)
    {
        return  new TimeEntryCollection(
            TimeEntry::with('tickets')->whereBetween('created_at',[
                str_replace('+', ' ',$request->get('date_from')),
                str_replace('+', ' ', $request->get('date_to')),
            ])->where('employee_id', '=', Auth::user()->id)->get()
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeEntry  $timeEntry
     * @return \Illuminate\Http\Response
     */
    public function show(TimeEntry $timeEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeEntry  $timeEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeEntry $timeEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeEntry  $timeEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeEntry $timeEntry)
    {
        //
    }
}
