<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DBController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/product', [DBController::class, 'product']);
Route::post('/product', [DBController::class, 'i_product']);
Route::put('/product/{id}', [DBController::class, 'u_product']);
Route::delete('/product/{id}', [DBController::class, 'd_product']);

Route::get('/factory', [DBController::class, 'factory']);
Route::post('/factory', [DBController::class, 'i_factory']);
Route::put('/factory/{id}', [DBController::class, 'u_factory']);
Route::delete('/factory/{id}', [DBController::class, 'd_factory']);

Route::get('/materials', [DBController::class, 'materials']);
Route::post('/materials', [DBController::class, 'i_materials']);
Route::put('/materials/{id}', [DBController::class, 'u_materials']);
Route::delete('/materials/{id}', [DBController::class, 'd_materials']);

Route::get('/category', [DBController::class, 'category']);
Route::post('/category', [DBController::class, 'i_category']);
Route::put('/category/{id}', [DBController::class, 'u_category']);
Route::delete('/category/{id}', [DBController::class, 'd_category']);

Route::get('/component', [DBController::class, 'component']);
Route::post('/component', [DBController::class, 'i_component']);
Route::delete('/component/{id}', [DBController::class, 'd_component']);

Route::get('/production', [DBController::class, 'production']);
Route::post('/production', [DBController::class, 'i_production']);
Route::put('/start/{id}', [DBController::class, 'start']);
Route::put('/mad/{id}', [DBController::class, 'mad']);
Route::get('/reportPC/{id}', [DBController::class, 'r_production']);

Route::get('/purchase', [DBController::class, 'purchase']);
Route::post('/purchase', [DBController::class, 'i_purchase']);
Route::put('/purchase/{id}', [DBController::class, 'u_purchase']);
Route::delete('/purchase/{id}', [DBController::class, 'd_purchase']);

Route::get('/vendor', [DBController::class, 'vendor']);
Route::post('/vendor', [DBController::class, 'i_vendor']);
Route::put('/vendor/{id}', [DBController::class, 'u_vendor']);
Route::delete('/vendor/{id}', [DBController::class, 'd_vendor']);

Route::get('/customer', [DBController::class, 'customer']);
Route::post('/customer', [DBController::class, 'i_customer']);
Route::put('/customer/{id}', [DBController::class, 'u_customer']);
Route::delete('/customer/{id}', [DBController::class, 'd_customer']);

Route::get('/sales', [DBController::class, 'sales']);
Route::post('/sales', [DBController::class, 'i_sales']);
Route::put('/sales/{id}', [DBController::class, 'u_sales']);
Route::delete('/sales/{id}', [DBController::class, 'd_sales']);

Route::get('kab/{id}', [DBController::class, 'kab']);