<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;


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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('custom.login');

Route::middleware('auth:sanctum')->group(function () {

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
Route::put('/employees/{id}/assign-role', [EmployeeController::class, 'assignRole'])
    ->middleware(AdminMiddleware::class);
});

Route::post('/employees/search', [EmployeeController::class, 'searchByName']);
Route::get('/employees/{id}/search', [EmployeeController::class, 'searchById']);


Route::put('/employees/{id}/update-status', [EmployeeController::class, 'updateStatus'])
->middleware(AdminMiddleware::class);

Route::middleware([AdminMiddleware::class])->group(function () {
Route::get('/admin/total-employees', [AdminDashboardController::class, 'totalEmployees']);
Route::get('/admin/total-roles', [AdminDashboardController::class, 'totalRoles']);
Route::post('/admin/roles', [AdminDashboardController::class, 'createRole']);
Route::delete('/admin/roles/{id}', [AdminDashboardController::class, 'deleteRole']);
});
