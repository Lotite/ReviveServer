<?php

namespace App\Class;

use App\Class\Table;
use App\Database\BD;
use App\Models\Media;
use App\Models\Episode;

class Episodes extends Table
{
    /**
     * Verifica si una variable es una instancia de Episodes.
     *
     * @param mixed $list Variable a verificar.
     * @return bool Verdadero si es instancia de Episodes, falso en caso contrario.
     */
    public static function isEpisodesList($list)
    {
        return $list instanceof Episodes;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $episodeItem) {
                $episode = Episode::NewEpisode($episodeItem);
                $this->add($episode);
            }
        } elseif (self::isEpisodesList($input)) {
            foreach ($input as $episode) {
                $this->add($episode);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $episode) {
                if (($episode instanceof Episode)) {
                    $this->add($episode);
                }
            }
        }
    }

    /**
     * Añade un nuevo objeto Episode a la colección.
     *
     * @param Episode $episode Nuevo episode a añadir.
     */
    public function add($episode)
    {
        parent::add($episode);
    }

    /**
     * Devuelve una lista filtrada de episodes según el callback.
     *
     * @param callable(Episode): bool $callback Función de filtro.
     * @return Episodes Nueva instancia de Episodes con episodes filtradas.
     */
    public function where(callable $callback): Episodes
    {
        return new Episodes(parent::where($callback));
    }

    /**
     * Devuelve el primer episode que coincide con la condición o null si no hay ninguno.
     *
     * @param callable(Episode): bool|null $callback Función de condición.
     * @return Episode|null Primer episode que coincide con la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Episode
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún episode cumple con la condición dada.
     *
     * @param callable(Episode): bool|null $callback Función de condición.
     * @return bool Verdadero si algún episode cumple, falso en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }

    /**
     * Crea un nuevo episodio en la base de datos.
     *
     * @param array $data Datos del episodio a crear.
     * @return bool True si el episodio se creó correctamente, false en caso contrario.
     */
    public static function create(array $data): array|bool
    {
        // First create media
        $mediaId = Media::create([
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'release_date' => $data['release_date'] ?? null,
            'tmdb_id' => $data['tmdb_id'] ?? null,
            'type' => 'episode',
        ]);

        if (!$mediaId) {
            return false;
        }

        $episodeCreated = BD::InsertIntoTable('episodes', [
            'media_id' => $mediaId,
            'season_id' => $data['season_id'] ?? null,
            'duration' => $data['duration'] ?? null,
            'episode_number' => $data['episode_number'] ?? null,
        ]);

        if (!$episodeCreated) {
            return false;
        }

        $id = BD::getLastInsertIdForTable("episodes");

        return ["id" => $id, "id_media" => $mediaId];
    }
}
