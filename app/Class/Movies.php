<?php

namespace App\Class;

use App\Class\Table;
use App\Database\BD;
use App\Models\Media;
use App\Models\Movie;


class Movies extends Table
{




    /**
     * Verifica si una variable es una instancia de Movies.
     *
     * @param mixed $list Variable a verificar.
     * @return bool Verdadero si es instancia de Movies, falso en caso contrario.
     */
    public static function isMoviesList($list)
    {
        return $list instanceof Movies;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $movieItem) {
                $movie = Movie::NewMovie($movieItem);
                $this->add($movie);
            }
        } elseif (self::isMoviesList($input)) {
            foreach ($input as $movie) {
                $this->add($movie);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $movie) {
                if (($movie instanceof Movie)) {
                    $this->add($movie);
                }
            }
        }
    }

    /**
     * Añade un nuevo objeto Movie a la colección.
     *
     * @param Movie $movie Nuevo movie a añadir.
     */
    public function add($movie)
    {
        parent::add($movie);
    }

    /**
     * Devuelve una lista filtrada de movies según el callback.
     *
     * @param callable(Movie): bool $callback Función de filtro.
     * @return Movies Nueva instancia de Movies con movies filtrados.
     */
    public function where(callable $callback): Movies
    {
        return new Movies(parent::where($callback));
    }

    /**
     * Devuelve el primer movie que coincide con la condición o null si no hay ninguno.
     *
     * @param callable(Movie): bool|null $callback Función de condición.
     * @return Movie|null Primer movie que coincide con la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Movie
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún movie cumple con la condición dada.
     *
     * @param callable(Movie): bool|null $callback Función de condición.
     * @return bool Verdadero si algún movie cumple, falso en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }

    /**
     * Crea un nuevo registro de película en la base de datos.
     *
     * @param Movie $movie El objeto Movie a insertar.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public static function create(array $movie): bool|int
    {

        $result = Media::create($movie);

        if ($result) {
            $data = [
                'media_id' => $result,
                'duration' => $movie["duration"],
            ];
            if (BD::InsertIntoTable('movies', $data))
                return $result;
        }

        return false;

    }
}
