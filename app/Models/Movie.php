<?php

namespace App\Models;

use App\Database\BD;
use App\Models\Media;

class Movie
{
    public int $id;
    public int $media_id;
    public ?int $duration;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->media_id = $data['media_id'] ?? 0;
        $this->duration = $data['duration'] ?? null;
    }

    /**
     * Método estativo que devuelve un Movie.
     *
     * @param array|object $data
     * @return Movie
     */
    public static function NewMovie($data): Movie
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        
        return new Movie([
            'id' => $data['id'] ?? 0,
            'media_id' => $data['media_id'] ?? 0,
            'duration' => $data['duration'] ?? null,
        ]);
    }
    

    /**
     * Devuelve el objeto Media asociado con este Movie.
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
