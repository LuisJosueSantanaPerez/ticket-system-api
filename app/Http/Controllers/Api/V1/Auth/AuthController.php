<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreAuthRequest;
use App\Http\Resources\V1\DepartmentCollection;
use App\Http\Resources\V1\AuthResource;
use App\Http\Resources\V1\EmployeeResource;
use App\Models\Employee;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * @param StoreAuthRequest $request
     * @return AuthResource|Application|ResponseFactory|Response
     */
    public function login(StoreAuthRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))){
            return $this->failure('Unauthorized', "login",401);
        }

        return new AuthResource($request->user());
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->success('Successfully logout' , null,"logout");
    }

    public function verify(Request $request){
        try {
            $user = [
                'id' => $request->user()->number,
                'first_name'=> $request->user()->first_name,
                'last_name'=> $request->user()->last_name,
                'email'=> $request->user()->email,
                'token' => $request->bearerToken()
            ];
            return $this->success('Successfully verify' , $user ,"verify");
        } catch (\Exception $e){
            return $this->failure('Unauthorized', "verify",401);
        }
    }
}
