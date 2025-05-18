<?php

namespace App\Models;

class GeneroMedia
{
    public int $id;
    public int $media_id;
    public int $genero_id;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->media_id = $data['media'] ?? ($data['media_id'] ?? 0);
        $this->genero_id = $data['genero'] ?? ($data['genero_id'] ?? 0);
    }

    /**
     * Método estático que devuelve una instancia de GeneroMedia.
     *
     * @param array|object $data
     * @return GeneroMedia
     */
    public static function NewGeneroMedia($data): GeneroMedia
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        return new GeneroMedia($data);
    }
}
