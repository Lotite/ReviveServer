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

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->season_id = $data['season_id'] ?? null;
        $this->media_id = $data['media_id'] ?? 0;
        $this->episode_number = $data['episode_number'] ?? null;
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
        
        return new Episode($data);
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
}
