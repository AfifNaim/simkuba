<?php

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CashBookController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StatisticController;
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
Route::get('/',  function() {
    return view('landing_page');
});

Route::group(['middleware'=>['auth','verified']], function(){
    Route::get('users/update_profile', [UserController::class, 'update_profile'])->name('users.update_profile');
    Route::get('users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::resource('users', UserController::class);
    Route::get('email/verify', [VerificationController::class, 'index'])->name('email.verify');
    Route::resource('categories', CategoriesController::class)->except(['show']);
    Route::resource('cash-books', CashBookController::class);
    Route::resource('companies', CompanyController::class)->except('show', 'delete');
    Route::get('companies/profile', [CompanyController::class, 'profile'])->name('companies.profile');
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::resource('home', HomeController::class);
    Route::get('report/report_monthly', [\App\Http\Controllers\ReportController::class, 'report_monthly'])->name('report.report_monthly');
    Route::get('report/report_daily', [\App\Http\Controllers\ReportController::class, 'report_daily'])->name('report.report_daily');
    Route::get('report/report_annual', [\App\Http\Controllers\ReportController::class, 'report_annual'])->name('report.report_annual');
    Route::resource('report', ReportController::class)->only('index');
    Route::get('report/excel', [\App\Http\Controllers\ReportController::class, 'report_excel'])->name('report.report_excel');
    Route::get('report/pdf', [\App\Http\Controllers\ReportController::class, 'report_pdf'])->name('report.report_pdf');
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('report/chart/{reportType}', [\App\Http\Controllers\DashboardController::class, 'report'])->name('report.chart');

});

Route::get('/login/google', [GoogleLoginController::class,'redirectToProvider'])->name('login-google');
Route::get('/login/google/callback', [GoogleLoginController::class,'handleProviderCallback']);

Auth::routes(['verify' => true]);
