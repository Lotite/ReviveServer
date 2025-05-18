<?php

namespace App\Http\Controllers\Api;

use App\Database\BD;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaControler extends Controller
{
  public function getMedias()
  {
   

    return Controller::responseMessage(success: true, data: BD::$Medias->firstOrNull());
  }

  public function home()
  {
    $allGeneros = BD::$Generos;
    $generosArray = iterator_to_array($allGeneros);
    shuffle($generosArray);
    $selectedGeneros = array_slice($generosArray, 0, 5);

    $result = [];

    foreach ($selectedGeneros as $genero) {
      $mediasOfGenero = BD::$Medias->where(function ($media) use ($genero) {
        return $media->isOfGenero($genero->id);
      })->getDTO_List();

      $mediasArray = iterator_to_array($mediasOfGenero);
      shuffle($mediasArray);
      $selectedMedias = array_slice($mediasArray, 0, 8);

      $result[] = [
        'genero' => $genero,
        'medias' => $selectedMedias,
      ];
    }

    return Controller::responseMessage(success: true, data: $result);
  }
}
