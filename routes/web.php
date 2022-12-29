<?php

use App\Http\Controllers\Admin\AbonmtController;
use App\Http\Controllers\Admin\DashbordController;
use App\Http\Controllers\Admin\EmplyController;
use App\Http\Controllers\Admin\ReservController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\api\ContractsController;
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

Route::get('/', function () {
    return view('coming_soon');
});

// Route::get('/pdf', [ContractsController::class, 'get_pdf']);

// admin panel
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function () {

    Route::get('/', [DashbordController::class, 'index'])->name('admin.index');
    Route::resource('/reserv', ReservController::class, ['names' => 'admin.reserv']);
    Route::resource('/abonmt', AbonmtController::class, ['names' => 'admin.abonmt']);
    Route::resource('/emply', EmplyController::class, ['names' => 'admin.emply']);
    Route::resource('/users', UsersController::class, ['names' => 'admin.users']);
    Route::resource('/entreps', EntrepsController::class, ['names' => 'admin.entreps']);

    /* -------- Admins list ------- */
    Route::get('/administrateurs', [UsersController::class, 'admins'])->name('admin.users.admins');

    /* -------- charts ------- */
    Route::get('/charts', [DashbordController::class, 'charts'])->name('admin.charts');
    Route::get('/dataSearch/{query?}', [DashbordController::class, 'dataSearch'], function ($query = null) {
        return $query;
    })->name('admin.dataSearch');

    /* -------- Devis ------- */
    Route::get('/devis', [DashbordController::class, 'devis'])->name('admin.devis');
    Route::get('/Devisearch/{query?}', [DashbordController::class, 'devisearch'], function ($query = null) {
        return $query;
    })->name('admin.devisearch');

    /* -------- Candidatures ------- */
    Route::get('/candidatures', [DashbordController::class, 'candidatures'])->name('admin.candidatures');
    Route::get('/Candidatsearch/{query?}', [DashbordController::class, 'candidatsearch'], function ($query = null) {
        return $query;
    })->name('admin.candidatsearch');

    /* -------- Searching / listing ------- */
    // search reserv list
    Route::get('/search/{query?}', [ReservController::class, 'search'], function ($query = null) {
        return $query;
    })->name('admin.search');
    // search abonmt list
    Route::get('/Abonmtsearch/{query?}', [AbonmtController::class, 'search'], function ($query = null) {
        return $query;
    })->name('admin.Abonmtsearch');
    // search emply list
    Route::get('/Emplysearch/{query?}', [EmplyController::class, 'search'], function ($query = null) {
        return $query;
    })->name('admin.Emplysearch');
    // search users list
    Route::get('/Usersearch', [UsersController::class, 'search'])->name('admin.Usersearch');
    // search entreps list
    Route::get('/Entrepsearch/{query?}', [EntrepsController::class, 'search'], function ($query = null) {
        return $query;
    })->name('admin.Entrepsearch');
    // search reserv history list for an emply
    Route::get('/emply/{id}/history', [EmplyController::class, 'history'])->name('admin.emply.history');
    Route::get('/Reservsearch/{id}/{query?}', [EmplyController::class, 'reservsearch'], function ($query = null) {
        return $query;
    })->name('admin.Reservsearch');
    // search sub history list for an emply
    Route::get('/emply/{id}/historySub', [EmplyController::class, 'history_sub'])->name('admin.emply.historySub');
    Route::get('/Subsearch/{id}/{query?}', [EmplyController::class, 'subsearch'], function ($query = null) {
        return $query;
    })->name('admin.Subsearch');
});
