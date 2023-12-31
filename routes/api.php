<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
Route::get('/', function(){
    return response()->json([
        'status' => false,
        'message' => 'user unauthorized'
    ]);
})->name('login');

Route::get('product', [ProductController::class, 'index'])->middleware('auth:sanctum', 'ablity:product-list');
Route::post('createProduct', [ProductController::class, 'store'])->middleware('auth:sanctum', 'ablity:product-store');

Route::post('/register', [AuthController::class, 'registerUser'])->name('register-post');
Route::post('login', [AuthController::class, 'loginUser']);
