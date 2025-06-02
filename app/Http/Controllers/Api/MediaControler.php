<?php

namespace App\Http\Controllers\Api;

use App\Class\Episodes;
use App\Class\Generos;
use App\Class\Medias;
use App\Class\UserLists;
use App\Database\BD;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Episode;
use App\Models\Media;
use App\Models\Serie;
use App\Models\User;
use App\Models\UserList;
use DataManager;
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
        $serieID = Serie::getSeriesId($seriesMediaId);

        $seasonsData = BD::getData("seasons", "*", ["series_id" => $serieID]);

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

    public function getCarouselMedia(Request $request)
    {
        $type = $request->input('type', '');
        $medias = Medias::getRandomMediaByType($type, 10);

        return Controller::responseMessage(success: true, data: $medias);
    }

    public function hasContinuation(Request $request)
    {
        $mediaId = $request->input('media_id');
        $nextEpisode = Episode::nextEpisodie($mediaId);
        return Controller::responseMessage(success: true, data: $nextEpisode);
    }

    public function saveMediaToList(Request $request)
    {
        DataManager::initialize($request);
        $mediaId = $request->input('media_id');
        $token = DataManager::getData("device");
        if (!$token) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }
        $userId = Device::getUser($token);

        if (!$userId) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }

        if (UserLists::exist($userId, $mediaId)) {
            return Controller::responseMessage(success: false, message: 'La media ya está en la lista del usuario', status: 400);
        }

        $success = UserList::createNewUserList(["user_id" => $userId, "media_id" => $mediaId]);
        return Controller::responseMessage(success: $success, message: $success ? "Se guardo correctamente" : "Hubo algun problema");
    }

    public function deleteMediaFromList(Request $request)
    {
        DataManager::initialize($request);
        $mediaId = $request->input('media_id');
        $token = DataManager::getData("device");
        if (!$token) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }
        $userId = Device::getUser($token);

        if (!$userId) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }
        if (!UserLists::exist($userId, $mediaId)) {
            return Controller::responseMessage(success: false, message: 'La media no está en la lista del usuario', status: 404);
        }
        $userList = UserList::getUserList($mediaId, $userId);
        $success = UserList::deleteUserListById($userList->id);
        return Controller::responseMessage(success: $success, message: $success ? "Se elimino correctamente" : "Hubo algun problema");
    }

    public function isMediaInUserList(Request $request)
    {
        DataManager::initialize($request);
        $mediaId = $request->input('media_id');
        $token = DataManager::getData("device");
        if (!$token) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }
        $userId = Device::getUser($token);

        if (!$userId) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }

        $isInList = UserLists::exist($userId, $mediaId);

        return Controller::responseMessage(success: true, data: ["exist" => $isInList]);
    }

    public function getUserList(Request $request)
    {
        DataManager::initialize($request);
        $token = DataManager::getData("device");
        if (!$token) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }
        $userId = Device::getUser($token);

        if (!$userId) {
            return Controller::responseMessage(success: false, message: 'Usuario no autenticado', status: 401);
        }

        $userLists = UserLists::getUserList($userId);
        $medias = $userLists->toMedias()->getDTO_List();

        return Controller::responseMessage(success: true, data: $medias);
    }
}
