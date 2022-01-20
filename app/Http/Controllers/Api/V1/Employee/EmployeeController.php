<?php

namespace App\Http\Controllers\Api\V1\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreEmployeeRequest;
use App\Http\Resources\V1\EmployeeCollection;
use App\Http\Resources\V1\EmployeeResource;
use App\Models\Employee;
use App\Models\Employee as EmployeeAlias;
use App\Traits\RespondsWithHttpStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return EmployeeCollection|Application|ResponseFactory|Response
     */
    public function index(Request $request)
    {
        return new EmployeeCollection(
            Employee::where([
                    ['activated', 'like', '%' . $request->get('q') . '%'],
                    ['activated', '=' , $request->get('activated')],
                ])
                ->paginate(
                    (int)$request->get('per_page')
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmployeeRequest $request
     * @return Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            Employee::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'activated' => $request->activated,
            ]);
            DB::commit();
            return $this->success('Success', null, 'employees',201);
        } catch (Exception $e){
            DB::rollBack();
            return $this->failure("failure => $e");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param EmployeeAlias $employee
     * @return EmployeeResource
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreEmployeeRequest $request
     * @param EmployeeAlias $employee
     * @return Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:35',
            'last_name' => 'required|max:35',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'password' => 'confirmed'
        ]);

        if ($validator->fails()) {
            return $this->failure($validator->errors(), 'employees');
        }
        try {
            DB::beginTransaction();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->password = (strlen($request->password))? Hash::make($request->password): $employee->password;
            $employee->activated = $request->activated;
            $employee->save();
            DB::commit();
            return $this->success('Success', null, 'employees');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure(`failure => ${$e->getMessage()}`, 'employees');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EmployeeAlias $employee
     * @return Response
     */
    public function destroy(Request $request, Employee $employee)
    {
        if ($request->user()->id == $employee->id)
            return $this->failure("you cannot delete your own credentials", 'employees');
        try {
            DB::beginTransaction();
            $employee->delete();
            DB::commit();
            return $this->success('Success', null , 'employees',204);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), 'employees');
        }
    }
}
