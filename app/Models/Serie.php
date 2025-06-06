<?php

namespace App\Models;

use App\Database\BD;
use App\Models\Media;

class Serie
{
    public int $id;
    public int $media_id;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->media_id = $data['media_id'] ?? 0;
    }

    /**
     * Método estático que devuelve una Serie.
     *
     * @param array|object $data
     * @return Serie
     */
    public static function NewSerie($data): Serie
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        return Media::NewMedia($data);
    }


    /**
     * Devuelve el objeto Media asociado a esta Serie.
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
     * Obtiene el ID de la serie por el ID del media.
     *
     * @param int $mediaId
     * @return int|null
     */
    public static function getSeriesId(int $mediaId): ?int
    {
        $seriesData = BD::getFirstRow("series", "*", ["media_id" => $mediaId]);
        if (!$seriesData) {
            return null;
        }
        return $seriesData['id'] ?? null;
    }

    /**
     * Obtiene la duración de la serie.
     *
     * @return int
     */
    public function getDuration(): int
    {
        return BD::countData("seasons", ["series_id" => $this->id]);
    }
}
