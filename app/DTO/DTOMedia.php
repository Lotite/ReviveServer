<?php

namespace App\DTO;

use App\Database\BD;
use App\Models\Episode;
use App\Models\Media;
use App\Models\Movie;
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
    public ?string $url;
    protected $imgUrl = "https://image.tmdb.org/t/p/w1280/";
    //https://image.tmdb.org/t/p/original/

    /**
     * Método fábrica para crear DTOMedia desde diferentes fuentes.
     *
     * @param Media|array $source
     * @return self
     */
    public static function create($source): self
    {
        return new self($source);
    }

    /**
     * Constructor desde un modelo Media o un array (respuesta de la API TMDB).
     *
     * @param Media|array $source
     */
    public function __construct($source)
    {
        if ($source instanceof Media) {
            $this->id = $source->id;
            $this->title = $source->titulo;
            $idImg = $this->id % 10;
            $this->portada =  env('APP_URL') . "/media/$source->id/portada.webp";
            $this->banner = env('APP_URL') . "/media/$source->id/banner.webp";
            $this->description = $source->descripcion;
            $this->reseña = rand(30, 50) / 10;
            $this->date = $source->release_date;
            $this->number = 0;
            $this->type = $source->type;
            $this->clasificacion = 13;
            $this->generos = $source->getGenerosName();
            $this->reparto = $source->getRepartoName(true);
            $this->director = $source->getDirector();
            $this->url = env('APP_URL') .  "/media/$source->id/video.mp4";
            switch ($this->type) {
                case 'serie':
                    $seriesId = Serie::getSeriesId($source->id);
                    $this->duracion = BD::countData("seasons", ["series_id" => $seriesId]);
                    break;
                case 'season':
                    $seasonId = Season::getSeasionId($source->id);
                    $this->duracion = BD::countData("episodes", ["season_id" => $seasonId]);
                    break;
                case 'movie':
                    $this->duracion = Movie::getDuration($source->id);
                    break;
                case 'episode':
                    $this->duracion = Episode::getDuration($source->id);
                    break;
                default:
                    $this->duracion = 100;
                    break;
            }
        } elseif (is_array($source)) {
            $this->id = $source['id'] ?? 0;
            $this->title = $source['title'] ?? $source['name'] ?? '';
            $this->portada = $this->imgUrl . ($source['poster_path'] ?? '');
            $this->banner = $this->imgUrl . ($source['backdrop_path'] ?? '');
            $this->description = $source['overview'] ?? '';
            $this->reseña = $source['vote_average'] ?? 0;
            $this->date = $source['release_date'] ?? $source['first_air_date'] ?? '';
            $this->number = $source['episode_count'] ?? $source['season_number'] ?? 0;
            $this->type = $source['media_type'] ?? 'movie';
            $this->duracion = $source['runtime'] ?? $source['episode_run_time'][0] ?? null;
            $this->clasificacion = null;
            $this->generos = $source['genre_ids'] ?? [];
            $this->reparto = null;
            $this->director = null;
            $this->url = null;
        } else {
            throw new \InvalidArgumentException('Invalid source type for DTOMedia constructor.');
        }
    }
}
