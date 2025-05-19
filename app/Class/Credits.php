<?php

namespace App\Class;

use App\Class\Table;
use App\Models\Credit;

class Credits extends Table
{
    /**
     * Verifica si una variable es una instancia de Credits.
     *
     * @param mixed $list Variable a verificar.
     * @return bool True si es instancia de Credits, false en caso contrario.
     */
    public static function isCreditsList($list)
    {
        return $list instanceof Credits;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $creditItem) {
                $credit = Credit::NewCredit($creditItem);
                $this->add($credit);
            }
        } elseif (self::isCreditsList($input)) {
            foreach ($input as $credit) {
                $this->add($credit);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $credit) {
                if (($credit instanceof Credit)) {
                    $this->add($credit);
                }
            }
        }
    }

    /**
     * Agrega un nuevo objeto Credit a la colección.
     *
     * @param Credit $credit Nuevo crédito a agregar.
     */
    public function add($credit)
    {
        parent::add($credit);
    }

    /**
     * Devuelve una lista de créditos filtrados según el callback.
     *
     * @param callable(Credit): bool $callback Función para filtrar créditos.
     * @return Credits Nueva instancia de Credits con los créditos filtrados.
     */
    public function where(callable $callback): Credits
    {
        return new Credits(parent::where($callback));
    }

    /**
     * Devuelve el primer crédito que cumple la condición o null si no hay ninguno.
     *
     * @param callable(Credit): bool|null $callback Función para evaluar la condición.
     * @return Credit|null Primer crédito que cumple la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Credit
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún crédito cumple la condición dada.
     *
     * @param callable(Credit): bool|null $callback Función para evaluar la condición.
     * @return bool True si algún crédito cumple la condición, false en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }
}
