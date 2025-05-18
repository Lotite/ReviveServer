<?php

namespace App\Class;

use App\Class\Table;
use App\Database\BD;
use App\Models\Media;

use App\Class\Movies;

class Medias extends Table
{


    /**
     * Verifica si una variable es una instancia de Medias.
     *
     * @param mixed $list Variable a verificar.
     * @return bool Verdadero si es instancia de Medias, falso en caso contrario.
     */
    public static function isMediasList($list)
    {
        return $list instanceof Medias;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $mediaItem) {
                $media = Media::NewMedia($mediaItem);
                $this->add($media);
            }
        } elseif (self::isMediasList($input)) {
            foreach ($input as $media) {
                $this->add($media);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $media) {
                if (($media instanceof Media)) {
                    $this->add($media);
                }
            }
        }
    }

    /**
     * Carga la colección de Movies para los elementos media en esta lista de Medias.
     */
    public function getMovies(): Movies
    {
        $allMovies = BD::$Movies;
        $mediaIds = [];
        foreach ($this as $media) {
            if (isset($media->id)) {
                $mediaIds[] = $media->id;
            }
        }
        // Filtra las películas que tienen media_id en mediaIds
        $filteredMovies = $allMovies->where(function ($movie) use ($mediaIds) {
            return in_array($movie->media_id, $mediaIds);
        });
        return $filteredMovies;
    }


    /**
     * Añade un nuevo objeto Media a la colección.
     *
     * @param Media $media Nuevo media a añadir.
     */
    public function add($media)
    {
        parent::add($media);
    }

    /**
     * Devuelve una lista filtrada de media según el callback.
     *
     * @param callable(Media): bool $callback Función de filtro.
     * @return Medias Nueva instancia de Medias con media filtrado.
     */
    public function where(callable $callback): Medias
    {
        return new Medias(parent::where($callback));
    }

    /**
     * Devuelve el primer media que coincide con la condición o null si no hay ninguno.
     *
     * @param callable(Media): bool|null $callback Función de condición.
     * @return Media|null Primer media que coincide con la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Media
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún media cumple con la condición dada.
     *
     * @param callable(Media): bool|null $callback Función de condición.
     * @return bool Verdadero si algún media cumple, falso en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }

    /**
     * Devuelve una nueva instancia de Medias que contiene solo objetos Media asociados con alguna Movie.
     *
     * @return Medias Instancia filtrada de Medias.
     */
    public function getMediasWithMovies(): Medias
    {
        $movieMediaIds = [];
        foreach ($this->movies as $movie) {
            if (isset($movie->media_id)) {
                $movieMediaIds[] = $movie->media_id;
            }
        }
        return $this->where(function ($media) use ($movieMediaIds) {
            return in_array($media->id, $movieMediaIds);
        });
    }
}
