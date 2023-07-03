<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\KeyController;
use App\Http\Controllers\Api\KeyLogController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\WorkerController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");


Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->controller(WorkerController::class)->prefix('/workers')->group(function () {
    Route::post('', 'addWorker')->middleware('log.route');
    Route::get('', 'allWorkers');
    Route::put('{workerId}', 'updateWorker')->middleware('log.route');;
    Route::post('upload-image', 'upload');
});

Route::middleware('auth:sanctum')->controller(DepartmentController::class)->prefix('/departments')->group(function () {
    Route::post('', 'addDepartment');
    Route::get('', 'allDepartments');
    Route::put('{workerId}', 'updateWorker');
    Route::post('upload-image', 'upload');
});

Route::middleware('auth:sanctum')->controller(KeyController::class)->prefix('/keys')->group(function () {
    Route::post('', 'store');
    Route::get('', 'allKeys');
    Route::delete('{keyId}', 'delete');
    Route::put('{keyId}', 'update');
});

Route::middleware('auth:sanctum')->controller(KeyLogController::class)->prefix('/key-logs')->group(function () {
    Route::post('pick', 'pickKey')->middleware('log.route');
    Route::post('drop', 'dropKey')->middleware('log.route');
    Route::get('', 'keyLogs');
});

Route::middleware('auth:sanctum')->controller(AttendanceController::class)->prefix('/attendance')->group(function () {
    Route::post('take', 'takeAttendance')->middleware('log.route');
});

Route::middleware('auth:sanctum')->controller(EventController::class)->prefix('/events')->group(function () {
    Route::post('today', 'getTodayEvent')->middleware('log.route');
});

Route::middleware('auth:sanctum')->controller(DashboardController::class)->prefix('dashboard')->group(function () {
    Route::get('items', 'index');
});
