<?php

namespace App\Models;

use App\Database\BD;
use App\DTO\DTOMedia;
use App\Models\Genero;
use App\Class\Generos;

class Media
{
    public int $id;
    public string $titulo;
    public string $descripcion;
    public ?string $release_date;
    public ?int $tmdb_id;
    public ?string $type;

    public array $generos;



    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->titulo = $data['title'] ?? '';
        $this->descripcion = $data['description'] ?? '';
        $this->release_date = $data['release_date'] ?? null;
        $this->tmdb_id = $data['tmdb_id'] ?? null;
        $this->type = $data['type'] ?? null;
    }

    /**
     * Método estático que devuelve una instancia de Media.
     *
     * @param array|object \$data
     * @return Media
     */
    public static function NewMedia($data): Media
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        return new Media($data);
    }

    /**
     * Obtiene los géneros relacionados con este media.
     *
     * @return Generos Colección de géneros relacionados.
     */
    public function getGeneros(): Generos
    {
        $generoMediaRows = BD::getData("generomedia", "*", ["media_id" => $this->id]);

        $generoIds = [];
        foreach ($generoMediaRows as $row) {
            $generoIds[] = $row['genero_id'];
        }

        $generosData = BD::getDataIn("generos", "id", $generoIds);

        return new Generos($generosData);
    }

    /**
     * Verifica si esta media pertenece a un género dado.
     *
     * @param int $generoId ID del género a verificar.
     * @return bool Verdadero si pertenece, falso en caso contrario.
     */
    public function isOfGenero(int $generoId): bool
    {
        $generoMediaRows = BD::getData("generomedia", "*", ["media_id" => $this->id, "genero_id" => $generoId]);
        return !empty($generoMediaRows);
    }

    public function getDTO_Media(){
        return new DTOMedia($this);
    }
}
