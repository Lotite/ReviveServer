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
    public ?string $video;
    protected $imgUrl = "https://image.tmdb.org/t/p/w1280/";
    //https://image.tmdb.org/t/p/original/

    /**
     * Factory method to create DTOMedia from different sources.
     *
     * @param Media|array $source
     * @return self
     */
    public static function create($source): self
    {
        return new self($source);
    }

    /**
     * Constructor from Media model or array (TMDB API response).
     *
     * @param Media|array $source
     */
    public function __construct($source)
    {
        if ($source instanceof Media) {
            $this->id = $source->id;
            $this->title = $source->titulo;
            $idImg = $this->id % 10;
            $this->portada = "https://picsum.photos/400/100?random={$idImg}";
            $this->banner = "https://picsum.photos/1000/400?random={$idImg}";
            $this->description = $source->descripcion;
            $this->reseña = rand(30, 50) / 10;
            $this->date = $source->release_date;
            $this->number = 0;
            $this->type = $source->type;
            $this->clasificacion = 20;
            $this->generos = $source->getGenerosName();
            $this->reparto = $source->getRepartoName(true);
            $this->director = $source->getDirector();
            $this->video = "";
            switch ($this->type) {
                case 'serie':
                    $seriesId = Serie::getSeriesId($source->id);
                    $this->duracion = BD::countData("seasons", ["series_id" => $seriesId]);
                    break;
                case 'season':
                    $seasonId = Season::getSeasionId($source->id);
                    $this->duracion = BD::countData("episodes", ["season_id" => $seasonId]);
                    break;
                default:
                    $this->duracion = 100;
                    break;
            }
        } elseif (is_array($source)) {
            $this->id = $source['id'] ?? 0;
            $this->title = $source['title'] ?? $source['name'] ?? ''; // Handle both movie and TV titles
            $this->portada = $this->imgUrl . ($source['poster_path'] ?? '');
            $this->banner = $this->imgUrl . ($source['backdrop_path'] ?? '');
            $this->description = $source['overview'] ?? '';
            $this->reseña = $source['vote_average'] ?? 0;
            $this->date = $source['release_date'] ?? $source['first_air_date'] ?? ''; // Handle both movie and TV dates
            $this->number = $source['episode_count'] ?? $source['season_number'] ?? 0; // Handle episode/season number
            $this->type = $source['media_type'] ?? 'movie'; // Default to movie if not specified
            $this->duracion = $source['runtime'] ?? $source['episode_run_time'][0] ?? null; // Handle movie runtime and TV episode runtime
            $this->clasificacion = null; // TMDB API does not provide a direct classification
            $this->generos = $source['genre_ids'] ?? []; // Array of genre IDs
            $this->reparto = null; // Requires separate API call
            $this->director = null; // Requires separate API call
            $this->video = null; // Requires separate API call
        } else {
             throw new \InvalidArgumentException('Invalid source type for DTOMedia constructor.');
        }
    }
}
