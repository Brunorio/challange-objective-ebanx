<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/conta/criacao/bonus', [AccountController::class, 'create']);
Route::post('/conta', [AccountController::class, 'increaseBalance']);
Route::get('/conta', [AccountController::class, 'find']);

Route::post('/transacao', [TransactionController::class, 'pay']);
Route::post('/transacao/transferencia', [TransactionController::class, 'transfer']);
