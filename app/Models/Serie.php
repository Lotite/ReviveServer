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
     * Método estativo que devuelve un Serie.
     *
     * @param array|object $data
     * @return Serie
     */
    public static function NewSerie($data): Serie
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        
        return new Serie($data);
    }

    /**
     * Devuelve el objeto Media asociado con este Serie.
     *
     * @return Media|null
     */
    public function getMedia(): ?Media
    {
        return BD::$Medias->firstOrNull(function ($media) {
            return $media->id === $this->media_id;
        });
    }
}
