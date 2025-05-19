<?php

namespace App\Http\Controllers\Api;

use App\Class\Generos;
use App\Class\Medias;
use App\Database\BD;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaControler extends Controller
{
 

  public function home()
  {
    $recommendations = $this->recommendate();
    return Controller::responseMessage(success: true, data: $recommendations);
  }

  public function movies()
  {
    $recommendations = $this->recommendate("movie");
    return Controller::responseMessage(success: true, data: $recommendations);
  }

  public function series()
  {
    $recommendations = $this->recommendate("serie");
    return Controller::responseMessage(success: true, data: $recommendations);
  }

  public  function recommendate($tipo = ['movie', 'serie']){
    $generos = Generos::getRandomGeneros(6);
    $recommendations = [];

    foreach ($generos as $genero) {
      $medias = Medias::getRandomMediaWhitGenero($genero->id, 8,$tipo);
      $recommendations[] = [
        'genero' => $genero,
        'medias' => $medias
      ];
    }
    return $recommendations;
  }
}
