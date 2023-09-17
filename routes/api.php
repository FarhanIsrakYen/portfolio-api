<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProjectAndPublicationController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::resource('users', UserController::class)->except(['destroy']);
Route::resource('users/educations', EducationController::class);
Route::resource('users/experiences', ExperienceController::class);
Route::resource('users/projects-and-publications', ProjectAndPublicationController::class);
Route::resource('users/skills', SkillController::class);
