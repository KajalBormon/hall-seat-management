<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Models\Department;
use Inertia\Inertia;
use App\Http\Middleware\Language;
use Illuminate\Support\Facades\Route;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\Permission\RoleController;
use App\Http\Controllers\Permission\PermissionController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/localization/{locale}', [LocalizationController::class, 'localization'])->name('localization');
Route::get('/language-options', [LanguageController::class, 'getLanguageOptions'])->name('getLanguageOptions');


Route::middleware(Language::class)
    ->group(function () {

    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'pageTitle' => __('pageTitle.custom.login'),
        ]);
    })->middleware('guest');

    Route::get('/dashboard', function () {
        $breadcrumbs = Breadcrumbs::generate('dashboard');
        $permissions = session('permissions');
        $response = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => __('pageTitle.custom.home'),
            'permissions' => $permissions
        ];
        return Inertia::render('Dashboard', $response);
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        // Profile related routes
        Route::prefix('profile')->group(function() {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        // Permission related routes
        Route::resource('permissions', PermissionController::class)->except('show', 'destroy');
        Route::patch('permissions/{permission}/change-status', [PermissionController::class, 'changeStatus'])->name('permissions.changeStatus');

        // Roles related routes
        Route::resource('roles', RoleController::class);
        Route::post('assign-permission', [RoleController::class, 'assignPermissionToRole']);
        Route::delete('remove-assigned-permission', [RoleController::class, 'removePermissionFromRole']);
        Route::prefix('roles/{role}')->group(function() {
            Route::patch('change-status', [RoleController::class, 'changeStatus'])->name('roles.changeStatus');
            Route::delete('remove-user/{user}', [RoleController::class, 'removeUserFromRole'])->name('roles.removeUserFromRole');
        });

        // User related routes
        Route::resource('/users', UserController::class);
        Route::prefix('users/{user}')->group(function() {
            Route::patch('update-details', [UserController::class, 'updateDetails'])->name('users.updateDetails');
            Route::patch('update-email', [UserController::class, 'updateEmail'])->name('users.updateEmail');
            Route::patch('update-roles', [UserController::class, 'updateRoles'])->name('users.updateRoles');
            Route::patch('update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
            Route::patch('change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
        });

        //student related routes
        Route::resource('students', StudentController::class);

        //Department related routes
        Route::resource('departments', DepartmentController::class);
        Route::patch('/departments/{department}/change-status', [DepartmentController::class, 'changeStatus'])->name('departments.changeStatus');
    });
});


require __DIR__ . '/auth.php';

