<?php

use App\Http\Controllers\Api\AuthControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
require_once __DIR__ . "/../database/database.php";
require_once __DIR__ . "/../app/Functions/DataManager.php";

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
Route::post('/session', function () {
    DataManager::initialize();
    DataManager::setSessionData("h", "hola");
    return DataManager::getSessionData("h");
});