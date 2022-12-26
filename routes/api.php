<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WilayahController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\AuthController as APIAuthController;
use App\Http\Controllers\API\PaymentController as APIPaymentController;
use App\Http\Controllers\API\TransactionController as APITransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/provinces', [WilayahController::class, 'getProvinces']);
Route::get('/cities',[WilayahController::class, 'getCities']);
Route::get('/districts' ,[WilayahController::class, 'getDistricts']);
Route::get('/villages', [WilayahController::class,'getVillages']);
Route::get('/postalcodes', [WilayahController::class, 'getPostalcodes']);
Route::get('programs', [ProgramController::class, 'all_programs']);
Route::prefix('payment')->group(static function(){
    Route::post('/webhook/va/created', [APIPaymentController::class, 'get_va_created']);
    Route::post('/webhook/va/status', [APIPaymentController::class, 'get_va_response']);
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', [APIAuthController::class, 'profile']);
    Route::get('/logout', [APIAuthController::class, 'logout']);
    Route::prefix('payment')->group(static function(){
        Route::post('/create', [APIPaymentController::class, 'create_transaction']);
    });
    Route::prefix('transactions')->group(static function(){
        Route::get('/all', [APITransactionController::class, 'all_transactions']);
    });
    Route::put('/change/password', [APIAuthController::class, 'change_password']);
    Route::prefix('notification')->name('notification.')->group(static function () {
        Route::get('all', 'App\Http\Controllers\API\NotificationController@all_notifications');
    });
});
Route::get('/payment-methods', [APIPaymentController::class, 'bank_list']);

//API route for register new user
Route::post('/register', [APIAuthController::class, 'register']);
//API route for login user
Route::post('/login', [APIAuthController::class, 'login']);
Route::put('/verify/otp', [APIAuthController::class, 'verify_otp']);
Route::put('/resend/otp', [APIAuthController::class, 'resend']);
