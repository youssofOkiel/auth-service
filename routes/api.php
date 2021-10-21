<?php

use App\Http\Controllers\apiAdminController;
use App\Http\Controllers\apiPermissionController;
use App\Http\Controllers\apiRoleController;
use App\Http\Controllers\apiUserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['jwt.verify', 'admin']], function () {

    // get all roles
    Route::get('/admin/roles', [apiAdminController::class, 'roles']);
    // get all users
    Route::get('/admin/users', [apiAdminController::class, 'users']);

    // add new role
    Route::post('/admin/add-role', [apiRoleController::class, 'create']);

    // add new permission
    Route::post('/admin/add-permission', [apiPermissionController::class, 'create']);

    // add permission for exists role
    Route::post('/admin/role-permission', [apiRoleController::class, 'rolePermission']);

    // add role for exists user
    Route::post('/admin/user-role', [apiUserController::class, 'addRole']);
});
