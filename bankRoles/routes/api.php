<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[AuthController::class, 'login']);

Route::group(['prefix' => 'customers', 'middleware' => ['auth', 'role:admin']], function($router){
    Route::post('',[CustomerController::class,'create']);
    Route::get('',[CustomerController::class, 'index']) -> whitoutMiddleware(['role:admin'])->can('readcustomers');
    Route::get('/{id}', [CustomerController::class, 'show']);
    Route::put('/{id}', [CustomerController::class, 'update']);
    Route::post('/{id}', [CustomerController::class, 'destroy']);
});

Route::group(['prefix' => 'permissions', 'middleware' =>['auth', 'role:admin']], function($router){
    Route::get('list-roles-whit-permissions',[PermissionsController::class, 'listRolesWithPermissions']);
    Route::post('create',[PermissionsController::class, 'createRole']);
    Route::delete('delete-role/{id}',[PermissionsController::class, 'deleteRole']);
    Route::group(['prefix' => 'assign'],function($router){
        Route::post('to-role',[PermissionsController::class, 'assignPermissions']);
    });
    Route::group(['prefix' => 'remove'],function($router){
        Route::post('from-role',[PermissionsController::class, 'removePermission']);
    });
});