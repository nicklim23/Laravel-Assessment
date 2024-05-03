<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', [LoginController::class,'index']);
Route::post('/login',[UserController::class,'login']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [HomeController::class,'index'])->middleware('customAuth');
Route::get('/products', [ProductController::class,'listing'])->middleware('customAuth');
Route::post('/products', [ProductController::class, 'store'])->middleware('customAuth');
Route::get('/products/add', [ProductController::class,'create'])->middleware('customAuth');
Route::get('/products/{product}', [ProductController::class,'edit'])->middleware('customAuth');
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('customAuth');
Route::delete('/products/{product}', [ProductController::class,'destroy'])->middleware('customAuth');

// Auth::routes();

