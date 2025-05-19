<?php

namespace App\Class;

use App\Class\Table;
use App\Models\Contributor;

class Contributors extends Table
{
    /**
     * Verifica si una variable es una instancia de Contributors.
     *
     * @param mixed $list Variable a verificar.
     * @return bool True si es instancia de Contributors, false en caso contrario.
     */
    public static function isContributorsList($list)
    {
        return $list instanceof Contributors;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $contributorItem) {
                $contributor = Contributor::NewContributor($contributorItem);
                $this->add($contributor);
            }
        } elseif (self::isContributorsList($input)) {
            foreach ($input as $contributor) {
                $this->add($contributor);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $contributor) {
                if (($contributor instanceof Contributor)) {
                    $this->add($contributor);
                }
            }
        }
    }

    /**
     * Agrega un nuevo objeto Contributor a la colección.
     *
     * @param Contributor $contributor Nuevo contribuidor a agregar.
     */
    public function add($contributor)
    {
        parent::add($contributor);
    }

    /**
     * Devuelve una lista de contribuidores filtrados según el callback.
     *
     * @param callable(Contributor): bool $callback Función para filtrar contribuidores.
     * @return Contributors Nueva instancia de Contributors con los contribuidores filtrados.
     */
    public function where(callable $callback): Contributors
    {
        return new Contributors(parent::where($callback));
    }

    /**
     * Devuelve el primer contribuidor que cumple la condición o null si no hay ninguno.
     *
     * @param callable(Contributor): bool|null $callback Función para evaluar la condición.
     * @return Contributor|null Primer contribuidor que cumple la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Contributor
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún contribuidor cumple la condición dada.
     *
     * @param callable(Contributor): bool|null $callback Función para evaluar la condición.
     * @return bool True si algún contribuidor cumple la condición, false en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }
}
