<?php

namespace App\DTO;

use App\Database\BD;
use App\Models\Media;
use App\Models\Season;
use App\Models\Serie;

class DTOMedia
{
    public int $id;
    public string $title;
    public string $portada;
    public string $banner;
    public string $description;
    public int $reseña;
    public string $date;
    public int $number;
    public string $type; // "movie" | "serie" | "season" | "episodie"
    public ?int $duracion;
    public ?int $clasificacion;
    public ?array $generos;
    public ?array $reparto;
    public ?string $director;
    //https://image.tmdb.org/t/p/original/
    public function __construct(Media $media)
    {
        $this->id = $media->id;
        $this->title = $media->titulo;
        $idImg = $this->id % 10;
        $this->portada = "https://picsum.photos/400/100?random=" . $idImg;
        $this->banner = "https://picsum.photos/1000/400?random=" . $idImg;
        $this->description = $media->descripcion;
        $this->reseña = rand(30, 50) / 10;
        $this->date = $media->release_date;
        $this->number = 0;
        $this->type = $media->type;
        $this->clasificacion = 20;
        $this->generos = $media->getGenerosName();
        $this->reparto = $media->getRepartoName(true);
        $this->director = $media->getDirector();

        switch ($this->type) {
            case 'serie':
                $seriesId = Serie::getSeriesId($media->id);
                $this->duracion = BD::countData("seasons", ["series_id" => $seriesId]);
                break;
            case 'season':
                $seasonId = Season::getSeasionId($media->id);
                $this->duracion = BD::countData("episodes", ["season_id" => $seasonId]);
                break;
            default:
                $this->duracion = 100;
                break;
        }
    }
}
