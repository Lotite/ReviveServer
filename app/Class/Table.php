<?php

namespace App\Class;

use ArrayObject;



class Table extends ArrayObject
{
 
    public function __construct(?array $list = [])
    {
        parent::__construct($list);
    }

    /**
     * Filtra los elementos de la colección según un callback.
     *
     * @param callable $callback Función para filtrar elementos.
     * @return Table Nueva instancia de Table con los elementos filtrados.
     */
    public function where(callable $callback)
    {
        $newList = array_filter($this->toArray(), $callback);

        return new Table($newList);
    }

    /**
     * Devuelve el primer elemento que cumple la condición o null si no hay ninguno.
     *
     * @param callable|null $callback Función para evaluar la condición.
     * @return mixed|null Primer elemento que cumple la condición o null.
     */
    public function firstOrNull(?callable $callback = null)
    {
        $array = $callback != null ? self::where($callback) : $this ;

        $values = $array->Values();
        if (count($values) === 0) {
            return null;
        }

        return  $values[0];
    }

    /**
     * Devuelve las claves de los elementos en la colección.
     *
     * @return array Claves de los elementos.
     */
    public function Keys()
    {
        return array_keys($this->toArray());
    }

    /**
     * Devuelve los valores de los elementos en la colección.
     *
     * @return array Valores de los elementos.
     */
    public function Values()
    {
        return array_values($this->toArray());
    }

    /**
     * Convierte la colección a un array.
     *
     * @return array Array con los elementos de la colección.
     */
    public function toArray()
    {
        return (array)$this;
    }

    /**
     * Devuelve la cantidad de elementos en la colección.
     *
     * @return int Número de elementos.
     */
    public function count(): int
    {
        return count($this->toArray());
    }

    /**
     * Agrega un nuevo elemento a la colección.
     *
     * @param mixed $newItem Elemento a agregar.
     */
    public function add($newItem)
    {
        $this[] = $newItem;
    }

    /**
     * Verifica si algún elemento cumple la condición dada.
     *
     * @param callable|null $callback Función para evaluar la condición.
     * @return bool True si algún elemento cumple la condición, false en caso contrario.
     */
    public function any(callable $callback = null)
    {
        if($callback==null) $callback = function () {return $this->count() > 0; };
        return $this->firstOrNull($callback) != null;
    }
}
