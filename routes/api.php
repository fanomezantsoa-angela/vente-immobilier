<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\PublicationController;
use  App\Http\Controllers\VisiteController;
use  App\Http\Controllers\ImmobilierController;
use App\Http\Controllers\API\AuthController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('addpub', [PublicationController::class, 'store']);
Route::post('addvis', [VisiteController::class, 'store']);
Route::get('nbvis', [VisiteController::class, 'nombre']);
Route::get('filtretype/{typologie}', [ImmobilierController::class, 'filtreType']);
Route::post('addimmob', [ImmobilierController::class, 'store']);
Route::get('filtreregion/{region}', [ImmobilierController::class, 'filtreRegion']);
Route::get('filtreId', [ImmobilierController::class, 'filtreId']);
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('getUserID', 'getUserID');
});