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

  public function recommendate($tipo = ['movie', 'serie'])
  {
    $generos = Generos::getRandomGeneros(6);
    $recommendations = [];

    foreach ($generos as $genero) {
      $medias = Medias::getRandomMediaWhitGenero($genero->id, 8, $tipo);
      $recommendations[] = [
        'genero' => $genero,
        'medias' => $medias
      ];
    }
    return $recommendations;
  }

  public function recommendateSimilar(Request $request)
  {
    $mediaId = $request->input('media_id');
    $quantity = $request->input('quantity', 5); 

    $media = Medias::getMediaById($mediaId);

    if (!$media) {
      return Controller::responseMessage(success: false, message: 'Media no encontrada', status: 404);
    }

    $generos = $media->getGeneros()->getIds();
    $tipo = $media->type;

    $recommendations = Medias::getSimilarMedia($generos, $tipo, $mediaId, $quantity);

    return Controller::responseMessage(success: true, data: $recommendations);
  }

  public function searchMedia(Request $request)
  {
    $name = $request->input('name');

    $medias = Medias::searchMediaByName($name);

    return Controller::responseMessage(success: true, data: $medias);
  }

  public function getSeasonsAndEpisodes(Request $request)
  {
    $seriesMediaId = $request->input('media_id');

    $seasonsData = BD::getData("seasons", "*", ["series_id" => $seriesMediaId]);

    $seasons = [];
    foreach ($seasonsData as $seasonData) {
      $seasonMedia = Media::getMediaById($seasonData['media_id']);

      $episodesData = BD::getData("episodes", "*", ["season_id" => $seasonData['id']]);
      $episodes = [];
      foreach ($episodesData as $episodeData) {
        $episodeMedia = Media::getMediaById($episodeData['media_id']);
        if ($episodeMedia) {
          $episodes[] = $episodeMedia->getDTO_Media();
        }
      }

      if ($seasonMedia) {
        $seasons[] = [
          'season' => $seasonMedia->getDTO_Media(),
          'episodes' => $episodes
        ];
      }
    }

    return Controller::responseMessage(success: true, data: $seasons);
  }
}
