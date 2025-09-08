<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ForgetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserActivityController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/admin', [AuthController::class, 'redirectAdminLogin']);
Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login-check', [AuthController::class, 'loginCheck'])->name('admin.login.check');  //login check
Route::post('/admin/forget-password', [ForgetPasswordController::class, 'forgetPassword'])->name('admin.forget.password');
Route::post('/admin/change-password', [ForgetPasswordController::class, 'changePassword'])->name('admin.change.password');
Route::get('/admin/forget-password/show', [ForgetPasswordController::class, 'forgetPasswordShow'])->name('admin.forget.password.show');
Route::get('/admin/reset-password/{id}/{token}', [ForgetPasswordController::class, 'resetPassword'])->name('admin.reset.password');
Route::post('/admin/change-password', [ForgetPasswordController::class, 'changePassword'])->name('admin.change.password');

Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('profile/update', [ProfileController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Role Management Routes
    Route::resource('roles', RoleController::class);

    // Admin Management Routes
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/update', [AdminController::class, 'update'])->name('admin.update');
        Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
    });

    Route::prefix('password')->group(function () {
        Route::get('/', [ProfileController::class, 'password'])->name('admin.password'); // password change
        Route::post('/update', [ProfileController::class, 'passwordUpdate'])->name('admin.password.update'); // password update
    });

    Route::resources([
        'customers' => CustomerController::class,

    ]);




    //  Customer Routes
    Route::prefix('customers')->group(function () {
        Route::get('/customer-delete/{id}', [CustomerController::class, 'delete'])->name('customers.delete');
    });
    Route::get('/changeCustomerStatus', [CustomerController::class, 'changeCustomersStatus'])->name('customers.change-status');
    Route::get('/customer-fetch-data', [CustomerController::class, 'fetchData'])->name('customers.fetch-data');


    // User Activity Routes
    Route::prefix('user-activity')->group(function () {
        Route::get('/file-downloads', [UserActivityController::class, 'fileDownloads'])->name('user-activity.file-downloads');
        Route::get('/video-watches', [UserActivityController::class, 'videoWatches'])->name('user-activity.video-watches');
        Route::get('/ip-tracking', [UserActivityController::class, 'ipTracking'])->name('user-activity.ip-tracking');
    });
});
