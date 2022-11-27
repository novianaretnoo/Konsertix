<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PemesananController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/tickets', [TicketController::class, 'index']);
Route::get('/tickets/{id}', [TicketController::class, 'show']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });


    Route::post('/add-tickets', [TicketController::class, 'store']);
    Route::put('/update-tickets/{id}', [TicketController::class, 'update']);
    Route::delete('/delete-tickets/{id}', [TicketController::class, 'destroy']);

    Route::get('/pemesanans', [PemesananController::class, 'index']);
    Route::get('/pemesanans/{id}', [PemesananController::class, 'show']);
    Route::post('/add-pemesanans', [PemesananController::class, 'store']);
    Route::put('/update-pemesanans/{id}', [PemesananController::class, 'update']);
    Route::delete('/delete-pemesanans/{id}', [PemesananController::class, 'destroy']);

    Route::post('/add-transaksi', [TransaksiController::class, 'store']);
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
    Route::delete('/delete-transaksi/{id}', [TransaksiController::class, 'destroy']);
    Route::put('/update-transaksi/{id}', [TransaksiController::class, 'update']);

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});
