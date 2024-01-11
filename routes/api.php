<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\User\EducationController;
use App\Http\Controllers\User\ExperienceController;
use App\Http\Controllers\User\ProjectAndPublicationController;
use App\Http\Controllers\User\SkillController;
use Illuminate\Support\Facades\Route;

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

Route::get('/portfolio', [PortfolioController::class, 'index']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::group(['middleware' => 'auth.role:ROLE_ADMIN,','prefix' => 'admin'], function () {
    Route::resource('/permissions', PermissionController::class);
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permission.create');
    Route::resource('/users', UserController::class);
});

Route::group(['middleware' => 'auth.role:ROLE_USER,'], function () {
    // users
    Route::prefix('users')->group(function() {
        Route::get('/', [\App\Http\Controllers\User\UserController::class, 'index']);
        Route::put('/', [\App\Http\Controllers\User\UserController::class, 'update']);
        Route::put('/update-password', [\App\Http\Controllers\User\UserController::class, 'updatePassword']);
        Route::delete('/', [\App\Http\Controllers\User\UserController::class, 'deactivateAccount']);

        // education
        Route::apiResources([
            'educations' => EducationController::class,
            'experiences' => ExperienceController::class,
            'projects' => ProjectAndPublicationController::class,
            'skills' => SkillController::class,
        ]);
    });
});
