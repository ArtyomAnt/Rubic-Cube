<?php


use App\Http\Controllers\CubeController;
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

Route::get(
    'getCube/{id}',
    [CubeController::class, 'getCube']
)->where('id', '[0-9]+');

Route::get(
    'generate/',
    [CubeController::class, 'generate']
);
