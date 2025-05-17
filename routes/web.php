<?php

use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\callback;
require_once __DIR__ .  "/../database/database.php";





Route::get('/', function () {

    return "hola";
});


Route::get('/pruebas', function () {
    ;
    
    return BD::$Users->firstOrNull(function($user){return $user->getId()==24;});
});
