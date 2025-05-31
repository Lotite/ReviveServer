<?php

use App\Http\Controllers\Api\AuthControler;
use App\Http\Controllers\Api\MediaControler;
use App\Http\Controllers\Api\VerificationResponseControler;
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


Route::post('/deleteDevice', [AuthControler::class, "deleteDevice"]);
Route::post('/deleteUser', [AuthControler::class, "deleteUser"]);
Route::post('/logout', [AuthControler::class, "logout"]);
Route::post('/deleteOtherDevices', [AuthControler::class, "deleteOtherDevices"]);
Route::post('/getUserDevices', [AuthControler::class, "getUserDevices"]);
Route::post('/updateUser', [AuthControler::class, "updateUser"]);
Route::post('/changePassword', [AuthControler::class, "changePassword"]);
Route::post('/register', [AuthControler::class, "register"]);
Route::post('/login', [AuthControler::class, "login"]);
Route::post('/recoverRequest', [AuthControler::class, "recoverRequest"]);
Route::post('/recoverVerify', [AuthControler::class, "recoverVerify"]);
Route::post('/recoverReset', [AuthControler::class, "recoverReset"]);
Route::post('/validateSession', [AuthControler::class, "validateSession"]);
Route::post('/home', [MediaControler::class, "home"]);
Route::post('/movies', [MediaControler::class, "movies"]);
Route::post('/series', [MediaControler::class, "series"]);
Route::post('/recommendateSimilar', [MediaControler::class, "recommendateSimilar"]);
Route::post('/search', [MediaControler::class, 'searchMedia']);
Route::post('/seasonsAndEpisodes', [MediaControler::class, 'getSeasonsAndEpisodes']);
Route::get('/email/verify/{token}', [VerificationResponseControler::class, 'verifyEmail'])->name('verification.verify');
