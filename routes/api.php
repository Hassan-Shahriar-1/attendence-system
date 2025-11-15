<?php

use App\Http\Controllers\Grade\GradeController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('sections', SectionController::class)->except('show');
    Route::apiResource('grades', GradeController::class)->except('show');
    Route::apiResource('students', StudentController::class);
});
