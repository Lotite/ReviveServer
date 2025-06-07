<?php

namespace App\Models;

use App\Database\BD;
use App\Models\Media;

class Episode
{
    public int $id;
    public ?int $season_id;
    public int $media_id;
    public ?int $episode_number;
    public ?int $duration;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->season_id = $data['season_id'] ?? null;
        $this->media_id = $data['media_id'] ?? 0;
        $this->episode_number = $data['episode_number'] ?? null;
        $this->duration = $data['duration'] ?? null;
    }

    /**
     * Método estativo que devuelve un Episode.
     *
     * @param array|object $data
     * @return Episode
     */
    public static function NewEpisode($data): Episode
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        return new Episode([
            'id' => $data['id'] ?? 0,
            'season_id' => $data['season_id'] ?? null,
            'media_id' => $data['media_id'] ?? 0,
            'episode_number' => $data['episode_number'] ?? null,
            'duration' => $data['duration'] ?? null,
        ]);
    }

    /**
     * Devuelve el objeto Media asociado con este Episode.
     *
     * @return Media|null
     */
    public function getMedia(): ?Media
    {
        $mediaData = BD::getFirstRow("media", "*", ["id" => $this->media_id]);
        if (!$mediaData) {
            return null;
        }
        return Media::NewMedia($mediaData);
    }

    /**
     * Obtiene la duración de un episodio dado el ID del medio.
     *
     * @param int $mediaId El ID del medio (media).
     * @return int|null La duración del episodio en minutos, o null si no se encuentra.
     */
    public static function getDuration(int $mediaId): ?int
    {
        $episode = BD::getFirstRow("episodes", "*", ["media_id" => $mediaId]);
        if (!$episode) {
            return null;
        }
        return $episode['Duration'] ?? null;
    }


    /**
     * Obtiene un episodio por su ID de media.
     *
     * @param int $mediaId ID de la media.
     * @return Episode|null
     */
    public static function getEpisodeByMediaId(int $mediaId): ?Episode
    {
        $episodeData = BD::getFirstRow("episodes", "*", ["media_id" => $mediaId]);
        if (!$episodeData) {
            return null;
        }
        return Episode::NewEpisode([
            'id' => $episodeData['id'] ?? 0,
            'season_id' => $episodeData['season_id'] ?? null,
            'media_id' => $episodeData['media_id'] ?? 0,
            'episode_number' => $episodeData['episode_number'] ?? null,
            'duration' => $episodeData['duration'] ?? null,
        ]);
    }

    /**
     * Obtiene el siguiente episodio en una serie.
     *
     * @param int $mediaId ID de la media actual.
     * @return mixed
     */
    public static function nextEpisodie(int $mediaId)
    {
        $episode = self::getEpisodeByMediaId($mediaId);

        if (!$episode) {
            return false;
        }

        $seasonId = $episode->season_id;
        $episodeNumber = $episode->episode_number;

        $nextEpisodeData = BD::getFirstRow(
            "episodes",
            "*",
            [
                "season_id" => $seasonId,
                "episode_number" => $episodeNumber + 1,
            ]
        );

        if (!$nextEpisodeData) {
            return false;
        }

        $newCap = Episode::NewEpisode($nextEpisodeData);

        $nexMediaCap = BD::getFirstRow(
            "media",
            "*",
            [
                "id"=> $newCap->media_id,
            ]
        );

        return Media::NewMedia($nexMediaCap)->getDTO_Media();
    }
}
