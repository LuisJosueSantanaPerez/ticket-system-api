<?php

namespace App\Http\Controllers\Api\V1\Kind;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreKindRequest;
use App\Http\Resources\V1\KindCollection;
use App\Http\Resources\V1\KindResource;
use App\Models\Kind;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class KindController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return KindCollection|Application|ResponseFactory|Response
     */
    public function index(Request $request)
    {
        return new KindCollection(
            Kind::where('name', 'like', '%' . $request->get('q') . '%')
                ->paginate(
                    (int)$request->get('per_page')
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreKindRequest $request
     * @return Response
     */
    public function store(StoreKindRequest $request)
    {
        try {
            DB::beginTransaction();
            Kind::create([
                'name' => $request->name,
            ]);
            DB::commit();
            return $this->success('Success', null, 'kinds', 201);
        } catch (Exception $e){
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Kind $kind
     * @return KindResource
     */
    public function show(Kind $kind)
    {
        return new KindResource($kind);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Kind $kind
     * @return Response
     */
    public function update(Request $request, Kind $kind)
    {
        try {
            DB::beginTransaction();
            $kind->name = $request->name;
            $kind->save();
            DB::commit();
            return $this->success('Success', null, 'kinds');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Kind $kind
     * @return Response
     */
    public function destroy(Kind $kind)
    {
        try {
            DB::beginTransaction();
            $kind->delete();
            DB::commit();
            return $this->success('Success', null , 'kinds',204);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), 'kinds');
        }
    }
}
