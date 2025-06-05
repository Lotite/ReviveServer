<?php

namespace App\Models;

use App\Database\BD;

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


    /**
     * Asocia una media con una lista de géneros.
     *
     * @param int $mediaId El ID de la media.
     * @param array $generoIds Un array de IDs de géneros.
     * @return bool True si la asociación fue exitosa para todos los géneros, false en caso contrario.
     */
    public static function associateMediaWithGenres(int $mediaId, array $generoIds): bool
    {
        if (empty($generoIds)) {
            return true; // No genres to associate
        }

        $success = true;
        foreach ($generoIds as $generoId) {
            $data = [
                'media' => $mediaId,
                'genero' => $generoId,
            ];
            if (!BD::InsertIntoTable('generomedia', $data)) {
                $success = false;
            }
        }
        return $success;
    }
}
