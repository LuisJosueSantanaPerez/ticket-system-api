<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreDepartment;
use App\Http\Resources\V1\DepartmentResource;
use App\Models\Department;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return Application|ResponseFactory|Response
     */
    public function index()
    {
        try {

        } catch (\Exception $e){
            return $this->failure("failure => $e");
        }
        return $this->success('Success', DepartmentResource::collection(Department::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDepartment $request
     * @return Response
     */
    public function store(StoreDepartment $request)
    {
        try {
            DB::beginTransaction();
            $department = new Department();
            $department->description = $request->description;
            $department->activated = $request->activated;
            $department->save();
            DB::commit();
            return $this->success('Created', [], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return DepartmentResource
     */
    public function show(Department $department): DepartmentResource
    {
        return new DepartmentResource($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreDepartment $request
     * @param $id
     * @return Response
     */
    public function update(StoreDepartment $request, $id)
    {
        try {
            DB::beginTransaction();
            $department = Department::find((int)$id);
            $department->description = $request->description;
            $department->activated = $request->activated;
            $department->save();
            DB::commit();
            return $this->success('Success', []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $department = Department::find((int)$id);
            $department->delete();
            DB::commit();
            return $this->success('Success', null ,204);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }
}
