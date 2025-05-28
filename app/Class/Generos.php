<?php

namespace App\Class;

use App\Class\Table;
use App\Database\BD;
use App\Models\Genero;

class Generos extends Table
{
    /**
     * Verifica si una variable es una instancia de Generos.
     *
     * @param mixed $list Variable a verificar.
     * @return bool Verdadero si es instancia de Generos, falso en caso contrario.
     */
    public static function isGenerosList($list)
    {
        return $list instanceof Generos;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $generoItem) {
                $genero = Genero::NewGenero($generoItem);
                $this->add($genero);
            }
        } elseif (self::isGenerosList($input)) {
            foreach ($input as $genero) {
                $this->add($genero);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $genero) {
                if (($genero instanceof Genero)) {
                    $this->add($genero);
                }
            }
        }
    }

    /**
     * Añade un nuevo objeto Genero a la colección.
     *
     * @param Genero $genero Nuevo genero a añadir.
     */
    public function add($genero)
    {
        parent::add($genero);
    }

    /**
     * Devuelve una lista filtrada de generos según el callback.
     *
     * @param callable(Genero): bool $callback Función de filtro.
     * @return Generos Nueva instancia de Generos con generos filtrados.
     */
    public function where(callable $callback): Generos
    {
        return new Generos(parent::where($callback));
    }

    /**
     * Devuelve el primer genero que coincide con la condición o null si no hay ninguno.
     *
     * @param callable(Genero): bool|null $callback Función de condición.
     * @return Genero|null Primer genero que coincide con la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Genero
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún genero cumple con la condición dada.
     *
     * @param callable(Genero): bool|null $callback Función de condición.
     * @return bool Verdadero si algún genero cumple, falso en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }

    /**
     * Obtiene todos los generos desde la base de datos.
     *
     * @return self Nueva instancia de Generos con todos los generos obtenidos.
     */
    public static function getGeneros(): self
    {
        return new self(BD::getData("generos"));
    }

    /**
     * Obtiene una lista aleatoria de generos desde la base de datos.
     *
     * @param int $maxGeneros Número máximo de generos a obtener. Por defecto es 5.
     * @return self Nueva instancia de Generos con los generos aleatorios obtenidos.
     */
    public static function getRandomGeneros(int $maxGeneros = 5): self
    {
        $sql = "SELECT * FROM generos ORDER BY RAND() LIMIT $maxGeneros";
        $params = [$maxGeneros];
        $generosData = BD::getDataWithQuery($sql);
        return new self($generosData);
    }

    /**
     * Devuelve una lista de IDs de los generos en la colección.
     *
     * @return array<int>
     */

    
    public function getIds()
    {
        $ids = [];
        foreach ($this as $genero) {
            $ids[] = $genero->id;
        }
        return $ids;
    }
}
