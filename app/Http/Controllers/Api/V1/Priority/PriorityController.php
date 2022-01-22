<?php

namespace App\Http\Controllers\Api\V1\Priority;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePriorityRequest;
use App\Http\Resources\V1\PriorityCollection;
use App\Http\Resources\V1\PriorityResource;
use App\Models\Priority;
use App\Traits\RespondsWithHttpStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PriorityController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return PriorityCollection|Application|ResponseFactory|Response
     */
    public function index(Request $request)
    {
        if (sizeof($request->all())){
            return new PriorityCollection(
                filtersResources($request->all(),'name',
                    'priorities')
            );
        }

        return $this->success('Success', Priority::all() , 'priorities');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePriorityRequest $request
     * @return Response
     */
    public function store(StorePriorityRequest $request)
    {
        try {
            DB::beginTransaction();
            Priority::create([
                'name' => $request->name,
            ]);
            DB::commit();
            return $this->success('Success', null, 'priorities',201);
        } catch (Exception $e){
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Priority $priority
     * @return PriorityResource
     */
    public function show(Priority $priority)
    {
        return new PriorityResource($priority);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Priority $priority
     * @return Response
     */
    public function update(Request $request, Priority $priority)
    {
        try {
            DB::beginTransaction();
            $priority->name = $request->name;
            $priority->save();
            DB::commit();
            return $this->success('Success', null, 'priorities');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Priority $priority
     * @return Response
     */
    public function destroy(Priority $priority)
    {
        try {
            DB::beginTransaction();
            $priority->delete();
            DB::commit();
            return $this->success('Success', null , 'priorities',204);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), 'priorities');
        }
    }
}
