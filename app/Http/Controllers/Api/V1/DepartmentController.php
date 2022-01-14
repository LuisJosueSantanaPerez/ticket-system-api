<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDepartment;
use App\Http\Resources\V1\DepartmentCollection;
use App\Http\Resources\V1\DepartmentResource;
use App\Models\Department;
use App\Traits\RespondsWithHttpStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class DepartmentController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return DepartmentCollection
     */
    public function index(Request $request)
    {
        return new DepartmentCollection(filtersResources($request->all(),'departments'));
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
            return $this->success('Success', [], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Department $department
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
        } catch (Exception $e) {
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
            if (!$department) {
                return $this->failure("Identity does not exist");
            }
            $department->delete();
            DB::commit();
            return $this->success('Success', null ,204);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage());
        }
    }
}
