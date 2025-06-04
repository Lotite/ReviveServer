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
    public array $reparto;
    public array $director;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->titulo = $data['title'] ?? '';
        $this->descripcion = $data['description'] ?? '';
        $this->release_date = $data['release_date'] ?? null;
        $this->tmdb_id = $data['tmdb_id'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->reparto = [];
        $this->director = [];
    }

    /**
     * Método estático que devuelve una instancia de Media.
     *
     * @param array|object $data
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
        $generoMediaRows = BD::getData("generomedia", "*", ["media" => $this->id]);

        $generoIds = [];
        foreach ($generoMediaRows as $row) {
            $generoIds[] = $row['genero'];
        }

        $generosData = BD::getDataIn("generos", "id", $generoIds);

        return new Generos($generosData);
    }

    /**
     * Obtiene los nombres de los géneros relacionados con este media.
     *
     * @return array Array de strings con los nombres de los géneros.
     */
    public function getGenerosName(): array
    {
        $sql = "SELECT g.nombre_genero FROM generos g
                JOIN generomedia gm ON g.id = gm.genero
                WHERE gm.media = " . $this->id;
        $generosData = BD::getDataWithQuery($sql);

        $names = array_map(function ($genero) {
            return $genero['nombre_genero'];
        }, $generosData);

        return $names;
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

    public function getDTO_Media()
    {
        return new DTOMedia($this);
    }

    /**
     * Obtiene el reparto relacionado con este media.
     *
     * @param bool $includeDirector Indica si se debe incluir el director en el reparto.
     * @return array Lista de objetos Contributor que representan el reparto.
     */
    public function getReparto(bool $includeDirector = false): array
    {
        $sql = "SELECT c.* FROM creditos cr
                JOIN contributors c ON cr.ContributorID = c.id
                WHERE cr.mediaID = " . $this->id . " AND cr.departamento = 'Acting'";
        $contributorsData = BD::getDataWithQuery($sql);

        return $contributorsData;
    }

    /**
     * Obtiene el director relacionado con este media.
     *
     * @return string Nombres de los directores separados por comas.
     */
    public function getDirector(): string
    {
        $sql = "SELECT c.* FROM creditos cr
                JOIN contributors c ON cr.ContributorID = c.id
                WHERE cr.mediaID = " . $this->id . " AND cr.departamento = 'Directing'";
        $directorData = BD::getDataWithQuery($sql);

        $directorNames = array_map(function ($director) {
            return $director["nombre"];
        }, $directorData);

        return implode(", ", $directorNames);
    }

    /**
     * Obtiene los nombres del reparto relacionado con este media.
     *
     * @param bool $includeDirector Indica si se debe incluir el director en los nombres.
     * @return string Nombres del reparto separados por comas.
     */
    public function getRepartoName(bool $includeDirector = false): array
    {
        $sql = "SELECT c.nombre FROM creditos cr
                JOIN contributors c ON cr.ContributorID = c.id
                WHERE cr.mediaID = " . $this->id . " AND cr.departamento = 'Acting'";
        $repartoData = BD::getDataWithQuery($sql);

        $names = array_map(function ($contributor) {
            return $contributor['nombre'];
        }, $repartoData);

        if ($includeDirector) {
            $directorNames = $this->getDirector();
            if (!empty($directorNames)) {
                $names[] = $directorNames;
            }
        }

        return $names;
    }

    public static function getMediaById($mediaId)
    {
        $mediaInfo = BD::getFirstRow("media", "*", ["id" => $mediaId]);
        if (empty($mediaInfo)) {
            return null;
        }

        return Media::NewMedia($mediaInfo);
    }

    /**
     * Crea un nuevo registro de media en la base de datos.
     *
     * @param Media $media El objeto Media a insertar.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public static function create(array $media): bool|string
    {
        $data = [
            'title' => $media["title"],
            'description' => $media["description"],
            'release_date' => $media["release_date"],
            'tmdb_id' => $media["tmdb_id"],
            'type' => $media["type"],
        ];
        $result = BD::InsertIntoTable('media', $data);
        if ($result) {
            return BD::getLastInsertIdForTable("media");
        }
        return false;
    }
}
