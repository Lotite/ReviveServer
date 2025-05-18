<?php

use App\Http\Controllers\Api\AuthControler;
use App\Http\Controllers\Api\MediaControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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



Route::post('/register', [AuthControler::class, "register"]);
Route::post('/login', [AuthControler::class, "login"]);
Route::post('/validateSession', [AuthControler::class, "validateSession"]);
Route::post('/home', [MediaControler::class, "getMedias"]);