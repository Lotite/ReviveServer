<?php

namespace App\Class;

use App\Class\Table;
use App\Models\Serie;
use App\Class\BD; 

class Series extends Table
{
    /**
     * Verifica si una variable es una instancia de Series.
     *
     * @param mixed $list Variable a verificar.
     * @return bool Verdadero si es instancia de Series, falso en caso contrario.
     */
    public static function isSeriesList($list)
    {
        return $list instanceof Series;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $serieItem) {
                $serie = Serie::NewSerie($serieItem);
                $this->add($serie);
            }
        } elseif (self::isSeriesList($input)) {
            foreach ($input as $serie) {
                $this->add($serie);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $serie) {
                if (($serie instanceof Serie)) {
                    $this->add($serie);
                }
            }
        }
    }

    /**
     * Añade un nuevo objeto Serie a la colección.
     *
     * @param Serie $serie Nuevo serie a añadir.
     */
    public function add($serie)
    {
        parent::add($serie);
    }

    /**
     * Devuelve una lista filtrada de series según el callback.
     *
     * @param callable(Serie): bool $callback Función de filtro.
     * @return Series Nueva instancia de Series con series filtradas.
     */
    public function where(callable $callback): Series
    {
        return new Series(parent::where($callback));
    }

    /**
     * Devuelve el primer serie que coincide con la condición o null si no hay ninguno.
     *
     * @param callable(Serie): bool|null $callback Función de condición.
     * @return Serie|null Primer serie que coincide con la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Serie
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún serie cumple con la condición dada.
     *
     * @param callable(Serie): bool|null $callback Función de condición.
     * @return bool Verdadero si algún serie cumple, falso en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }
}
