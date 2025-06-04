<?php

namespace App\Class;

use App\Class\Table;
use App\Database\BD;
use App\Models\Media;
use App\Models\Season;

class Seasons extends Table
{
    /**
     * Verifica si una variable es una instancia de Seasons.
     *
     * @param mixed $list Variable a verificar.
     * @return bool Verdadero si es instancia de Seasons, falso en caso contrario.
     */
    public static function isSeasonsList($list)
    {
        return $list instanceof Seasons;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $seasonItem) {
                $season = Season::NewSeason($seasonItem);
                $this->add($season);
            }
        } elseif (self::isSeasonsList($input)) {
            foreach ($input as $season) {
                $this->add($season);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $season) {
                if (($season instanceof Season)) {
                    $this->add($season);
                }
            }
        }
    }

    /**
     * Añade un nuevo objeto Season a la colección.
     *
     * @param Season $season Nuevo season a añadir.
     */
    public function add($season)
    {
        parent::add($season);
    }

    /**
     * Devuelve una lista filtrada de seasons según el callback.
     *
     * @param callable(Season): bool $callback Función de filtro.
     * @return Seasons Nueva instancia de Seasons con seasons filtradas.
     */
    public function where(callable $callback): Seasons
    {
        return new Seasons(parent::where($callback));
    }

    /**
     * Devuelve el primer season que coincide con la condición o null si no hay ninguno.
     *
     * @param callable(Season): bool|null $callback Función de condición.
     * @return Season|null Primer season que coincide con la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Season
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún season cumple con la condición dada.
     *
     * @param callable(Season): bool|null $callback Función de condición.
     * @return bool Verdadero si algún season cumple, falso en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }

    /**
     * Crea una nueva temporada en la base de datos.
     *
     * @param array $data Datos de la temporada a crear.
     * @return bool True si la temporada se creó correctamente, false en caso contrario.
     */
    public static function create(array $data): array|bool
    {
        $mediaId = Media::create([
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'release_date' => $data['release_date'] ?? null,
            'tmdb_id' => $data['tmdb_id'] ?? null,
            'type' => 'season',
        ]);

        if (!$mediaId) {
            return false;
        }

        $seasonCreated = BD::InsertIntoTable('seasons', [
            'media_id' => $mediaId,
            'series_id' => $data['series_id'] ?? null,
            'season_number' => $data['season_number'] ?? null,
        ]);

        if (!$seasonCreated) {
            return false;
        }

        $id = BD::getLastInsertIdForTable("seasons");

        return ["id" => $id, "id_serie" => $data['series_id'], "id_media" => $mediaId];
    }
}
