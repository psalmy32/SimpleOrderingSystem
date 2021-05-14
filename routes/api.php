<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrdersController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::match(['post', 'get'], '/orders', [OrdersController::class, 'addOrder']);
Route::patch('/orders/{id}', [OrdersController::class, 'takeOrder']);
//Route::match(['post', 'get'], '/orders?page={page}&limit={limit}', [OrdersController::class, 'getAllOrders']);
