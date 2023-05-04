<?php

use App\Http\Controllers\Project\ProjectCreateController;
use App\Http\Controllers\Project\ProjectDestroyController;
use App\Http\Controllers\Project\ProjectEditController;
use App\Http\Controllers\Project\ProjectListController;
use App\Http\Controllers\Project\ProjectSendController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    //Create
    Route::get('/projects', ProjectCreateController::class)->name('projects.create.index');
    Route::post('/projects/store', [ProjectCreateController::class, 'store'])->name('projects.create.store');

    //Edit
    Route::get('/projects/edit/{project}', ProjectEditController::class)->name('projects.edit.index');
    Route::patch('/projects/edit/{project}', [ProjectEditController::class, 'update'])->name('projects.update');

    //Delete
    Route::delete('/projects/destroy/{project}', ProjectDestroyController::class)->name('projects.destroy');

    //List
    Route::get('/projects/list', ProjectListController::class)->name('projects.list');
    Route::get('/projects/list/export', [ProjectListController::class, 'export'])->name('projects.export');

    //Send
    Route::get('/projects/send/{project}', ProjectSendController::class)->name('projects.send');


});

require __DIR__ . '/auth.php';
