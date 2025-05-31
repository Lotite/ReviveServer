<?php

namespace App\Models;

use App\Database\BD;
use App\Models\Media;

class Season
{
    public int $id;
    public ?int $series_id;
    public int $media_id;
    public ?int $season_number;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->series_id = $data['series_id'] ?? null;
        $this->media_id = $data['media_id'] ?? 0;
        $this->season_number = $data['season_number'] ?? null;
    }

    /**
     * Static method that returns a Season.
     *
     * @param array|object $data
     * @return Season
     */
    public static function NewSeason($data): Season
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        
        return new Season($data);
    }

    /**
     * Returns the Media object associated with this Season.
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
     * Obtiene el ID de la temporada por el ID del media.
     *
     * @param int $mediaId
     * @return int|null
     */
    public static function getSeasionId(int $mediaId): ?int
    {
        $seasonData = BD::getFirstRow("seasons", "*", ["media_id" => $mediaId]);
        if (!$seasonData) {
            return null;
        }
        return $seasonData['id'] ?? null;
    }

    /**
     * Get the duration of the season.
     *
     * @return int
     */
    public function getDuration(): int
    {
        return BD::countData("episodes", ["season_id" => $this->id]);
    }
}
