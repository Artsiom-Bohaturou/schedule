<?php

use App\Http\Controllers\Admin\Group\GroupController;
use App\Http\Controllers\Admin\Group\GroupEducationTypeController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\Subject\SubjectController;
use App\Http\Controllers\Admin\Subject\SubjectTimeController;
use App\Http\Controllers\Admin\Subject\SubjectTypeController;
use App\Http\Controllers\Admin\Teacher\TeacherController;
use App\Http\Controllers\Admin\Teacher\TeacherDepartmentController;
use App\Http\Controllers\Admin\Teacher\TeacherPositionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::redirect('/', '/admin');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm' => false,
]);

Route::prefix('admin')->middleware('auth:web')->group(function () {
    Route::resource('', ScheduleController::class)->names('schedule');

    Route::prefix('subject')->as('subject.')->group(function () {
        Route::resource('/', SubjectController::class)->except(['create', 'edit', 'show'])->parameter('', 'id');
        Route::resource('/time', SubjectTimeController::class)->names('time')->only(['index', 'update']);
        Route::resource('/type', SubjectTypeController::class)->names('type')->except(['create', 'edit', 'show']);
    });

    Route::prefix('teacher')->as('teacher.')->group(function () {
        Route::resource('/', TeacherController::class)->except(['create', 'edit'])->parameter('', 'id')->whereNumber('id');
        Route::resource('/positions', TeacherPositionController::class)->names('position')->except(['create', 'edit', 'show']);
        Route::resource('/departments', TeacherDepartmentController::class)->names('department')->except(['create', 'edit', 'show']);

    });

    Route::prefix('group')->as('group.')->group(function () {
        Route::resource('/', GroupController::class)->except(['create', 'edit'])->parameter('', 'id')->whereNumber('id');
        Route::resource('/education', GroupEducationTypeController::class)->names('education')->except(['create', 'edit', 'show']);

    });
});
