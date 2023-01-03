<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
Route::get('/', [GuestController::class, 'landing_index']);
Route::get('/lembaga/daftar', [GuestController::class, 'lembaga_register']);
Route::post('/lembaga/daftar', [GuestController::class, 'lembaga_register_proses']);

Route::middleware('auth')->group(static function(){
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('users')->name('users.')->group(static function(){
        Route::get('/', [UsersController::class, 'index']);
        Route::get('create', [UsersController::class, 'create'])->name('create');
        Route::post('/', [UsersController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UsersController::class, 'update'])->name('update');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('destroy');
        Route::put('/{user}/restore', [UsersController::class, 'restore'])->name('restore');
    });
    Route::prefix('transactions')->name('transactions.')->group(static function(){
        Route::get('/', [TransactionController::class, 'all_transactions']);
        Route::get('/detail/{id}', [TransactionController::class, 'transaction_detail']);

    });
    Route::prefix('organizations')->name('organizations.')->group(static function(){
        Route::get('/', [LembagaController::class, 'index']);
        Route::get('{id}', [LembagaController::class, 'detail']);
        Route::get('approve/{id}', [LembagaController::class, 'approved']);
        Route::get('{id}/edit', [LembagaController::class, 'edit']);
        Route::get('reject/{id}', [LembagaController::class, 'reject']);

    });
    Route::prefix('program')->name('program.')->group(static function(){
        Route::get('approve/{id}', [ProgramController::class, 'approved']);

    });
    Route::resource('programs', ProgramController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('reports', ReportController::class);


});



// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
Route::get('/pdf/{path}', [ImagesController::class, 'get_pdf'])
    ->where('path', '.*')
    ->name('pdf');
