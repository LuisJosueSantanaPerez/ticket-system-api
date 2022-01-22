<?php

namespace App\Http\Controllers\Api\V1\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreStatusRequest;
use App\Http\Resources\V1\StatusCollection;
use App\Http\Resources\V1\StatusResource;
use App\Models\Status;
use App\Traits\RespondsWithHttpStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return StatusCollection|Application|ResponseFactory|Response
     */
    public function index(Request $request)
    {

        if (sizeof($request->all())){
            return new StatusCollection(
                filtersResources($request->all(),'name',
                    'statuses')
            );
        }

        return $this->success('Success', Status::all() , 'statuses');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStatusRequest $request
     * @return Response
     */
    public function store(StoreStatusRequest $request)
    {
        try {
            DB::beginTransaction();
            Status::create([
                'name' => $request->name,
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
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status)
    {
        return new StatusResource($status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Status $status
     * @return Response
     */
    public function update(Request $request, Status $status)
    {
        try {
            DB::beginTransaction();
            $status->name = $request->name;
            $status->save();
            DB::commit();
            return $this->success('Success', null, 'statuses');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Status $status
     * @return Response
     */
    public function destroy(Status $status)
    {
        try {
            DB::beginTransaction();
            $status->delete();
            DB::commit();
            return $this->success('Success', null , 'statuses',204);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), 'statuses');
        }
    }
}
