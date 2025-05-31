<?php

namespace App\Class;

use App\Class\Table;
use App\Models\Episode;
use App\Class\BD;

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
     * @return Episodes Nueva instancia de Episodes con episodes filtrados.
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
}
