<?php

namespace App\Class;

use App\Class\Table;
use App\Models\GeneroMedia;

class GenerosMedia extends Table
{
    /**
     * Verifica si una variable es una instancia de GenerosMedia.
     *
     * @param mixed $list Variable a verificar.
     * @return bool Verdadero si es instancia de GenerosMedia, falso en caso contrario.
     */
    public static function isGenerosMediaList($list)
    {
        return $list instanceof GenerosMedia;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $generoMediaItem) {
                $generoMedia = GeneroMedia::NewGeneroMedia($generoMediaItem);
                $this->add($generoMedia);
            }
        } elseif (self::isGenerosMediaList($input)) {
            foreach ($input as $generoMedia) {
                $this->add($generoMedia);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $generoMedia) {
                if (($generoMedia instanceof GeneroMedia)) {
                    $this->add($generoMedia);
                }
            }
        }
    }

    /**
     * Añade un nuevo objeto GeneroMedia a la colección.
     *
     * @param GeneroMedia $generoMedia Nuevo generoMedia a añadir.
     */
    public function add($generoMedia)
    {
        parent::add($generoMedia);
    }

    /**
     * Devuelve una lista filtrada de generosMedia según el callback.
     *
     * @param callable(GeneroMedia): bool $callback Función de filtro.
     * @return GenerosMedia Nueva instancia de GenerosMedia con generosMedia filtrados.
     */
    public function where(callable $callback): GenerosMedia
    {
        return new GenerosMedia(parent::where($callback));
    }

    /**
     * Devuelve el primer generoMedia que coincide con la condición o null si no hay ninguno.
     *
     * @param callable(GeneroMedia): bool|null $callback Función de condición.
     * @return GeneroMedia|null Primer generoMedia que coincide con la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?GeneroMedia
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún generoMedia cumple con la condición dada.
     *
     * @param callable(GeneroMedia): bool|null $callback Función de condición.
     * @return bool Verdadero si algún generoMedia cumple, falso en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }
}
