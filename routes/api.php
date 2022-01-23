<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\AuthController as AuthV1;
use App\Http\Controllers\Api\V1\Ticket\TicketController as TicketV1;
use App\Http\Controllers\Api\V1\Ticket\TicketEmployeeController as TicketEmployeeV1;
use App\Http\Controllers\Api\V1\Ticket\TicketTimeEntryController as TicketTimeEntryV1;
use App\Http\Controllers\Api\V1\Employee\EmployeeController as EmployeeV1;
use App\Http\Controllers\Api\V1\Employee\EmployeeTicketControlleer as EmployeeTicketV1;
use App\Http\Controllers\Api\V1\TimeEntry\TimeEntryController as TimeEntryV1;
use App\Http\Controllers\Api\V1\Report\ReportController as ReportV1;
use App\Http\Controllers\Api\V1\Priority\PriorityController as PriorityV1;
use App\Http\Controllers\Api\V1\Status\StatusController as StatusV1;
use App\Http\Controllers\Api\V1\Category\CategoryController as CategoryV1;
use App\Http\Controllers\Api\V1\Kind\KindController as KindV1;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// V1
Route::group(['prefix' => 'v1'], function (){
    // auth/login
    Route::get('auth/login', function(){
        return response(['message' => 'Authorization Token not found',], 401);
    });
    Route::post('auth/login', [AuthV1::class, 'login']);
});



Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], function (){
    // auth/logout
    Route::get('auth/logout', [AuthV1::class, 'logout']);
    // auth/verify
    Route::get('auth/verify', [AuthV1::class, 'verify']);
    // employees
    Route::apiResource('employees', EmployeeV1::class)
        ->only(['index','store', 'show', 'update', 'destroy']);
    // time-entry
    Route::apiResource('time-entry', TimeEntryV1::class)
        ->only(['index','store', 'show', 'update', 'destroy']);
    // tickets
    Route::apiResource('tickets', TicketV1::class)
        ->only(['index','store', 'show', 'update', 'destroy']);
    //ticket/{id}/time-entry
    Route::apiResource('tickets/{ticket}/time-entries', TicketTimeEntryV1::class)
        ->only(['index', 'show']);
    // reports
    Route::apiResource('reports', ReportV1::class)
        ->only(['index']);
    // assigned-tickets-employees
    Route::apiResource("assigned-tickets-employees", TicketEmployeeV1::class)
        ->only(['index', 'show']);
    // employees-assigneds-tickets
    Route::apiResource("employees-assigneds-tickets", EmployeeTicketV1::class)
        ->only(['index']);
    // priorities
    Route::apiResource('priorities', PriorityV1::class)
        ->only(['index','store', 'show', 'update', 'destroy']);
    // statuses
    Route::apiResource('statuses', StatusV1::class)
        ->only(['index','store', 'show', 'update', 'destroy']);
    // categories
    Route::apiResource('categories', CategoryV1::class)
        ->only(['index','store', 'show', 'update', 'destroy']);
    // kinds
    Route::apiResource('kinds', KindV1::class)
        ->only(['index','store', 'show', 'update', 'destroy']);
});
