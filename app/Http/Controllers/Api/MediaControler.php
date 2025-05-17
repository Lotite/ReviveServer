<?php

namespace App\Http\Controllers\Api;

use App\Database\BD;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaControler extends Controller
{
    public function getMedias(){
      return  Controller::responseMessage(success:true,data:["medias", BD::$Medias]);
    }
}
