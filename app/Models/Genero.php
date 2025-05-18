<?php

namespace App\Models;

use App\Database\BD;

class Genero
{
    public int $id;
    public string $nombre_genero;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->nombre_genero = $data['nombre_genero'] ?? '';
    }

    /**
     * Método estático que devuelve un Genero.
     *
     * @param array|object \$data
     * @return Genero
     */
    public static function NewGenero($data): Genero
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        
        return new Genero($data);
    }
}
