<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TestStepController;
use App\Http\Controllers\WorkflowController;
use App\Models\Project;
use App\Models\User;
use App\Models\Workflow;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [SessionController::class, "show"])->name('login');
Route::post('/login', [SessionController::class, "create"]);
Route::delete('/logout', [SessionController::class, "destroy"]);

Route::get('/register', [RegisteredUserController::class, "show"]);
Route::post('/register', [RegisteredUserController::class, "create"]);

Route::get('/discover', [ProjectController::class, "discover"]);

Route::get('/projects', [ProjectController::class, "index"]);

Route::get('/projects/create', function () {
    return view('project.create');
})->middleware('auth');
Route::post("/projects", [ProjectController::class, "create"])->middleware('auth');
Route::get('/projects/{project:slug}', [ProjectController::class, "show"]);
Route::delete('/projects/{project:slug}', [ProjectController::class, "destroy"])->middleware('auth');

Route::get('/projects/{project:slug}/create', [WorkflowController::class, "show"])->middleware('auth');
Route::post('/projects/{project:slug}/create', [WorkflowController::class, "create"])->middleware('auth');

Route::get('/projects/{project:slug}/workflows/{workflow:uuid}/create', [TestStepController::class, "show"])->middleware('auth');
Route::post('/projects/{project:slug}/workflows/{workflow:uuid}/create', [TestStepController::class, "create"])->middleware('auth');

Route::get('/profile/{user:username}', function (User $user) {
    return view('profile.profile', ["user" => $user]);
})->middleware('auth');