<?php

namespace App\Http\Controllers\Api\V1\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EmployeeResource;
use App\Http\Resources\V1\EmployeeTicketCollection;
use App\Http\Resources\V1\EmployeeTicketResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeTicketControlleer extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return EmployeeTicketCollection
     */
    public function index(Request $request)
    {
        return new EmployeeTicketCollection(
            Employee::with("tickets" )
                ->where('first_name', 'like', '%' . $request->get('q') . '%')
                ->paginate(
                    (int)$request->get('per_page')
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Employee $employee
     * @return Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
