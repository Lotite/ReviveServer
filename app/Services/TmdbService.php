<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\DTO\DTOMedia;
use App\Models\Media;

class TmdbService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.themoviedb.org/3/';
    protected $imgUer = "https://image.tmdb.org/t/p/w1280/";

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY'); // Assuming the API key is stored in the .env file
    }

    /**
     * Make a GET request to the TMDB API.
     *
     * @param string $endpoint The API endpoint (e.g., 'movie/popular')
     * @param array $params Query parameters
     * @return array|null
     */
    public function get(string $endpoint, array $params = []): ?array
    {
        $response = Http::withToken($this->apiKey)
            ->get($this->baseUrl . $endpoint, $params);

        if ($response->successful()) {
            return $response->json();
        }


        return null;
    }


    /**
     * Search for movies on TMDB.
     *
     * @param string $query The search query.
     * @param int $page The page number.
     * @param string $language The language (e.g., 'es-ES').
     * @return array An array of DTOMedia objects.
     */
    public function searchMovies(string $query, int $page = 1, string $language = 'es-ES'): array
    {
        $params = [
            'query' => $query,
            'include_adult' => false,
            'language' => $language,
            'page' => $page,
        ];

        $response = $this->get('search/movie', $params);

        $dtoMediaResults = [];
        if ($response && isset($response['results'])) {
            foreach ($response['results'] as $movieData) {
                $dtoMediaResults[] = DTOMedia::create($movieData);
            }
        }

        return $dtoMediaResults;
    }

    /**
     * Search for TV series on TMDB.
     *
     * @param string $query The search query.
     * @param int $page The page number.
     * @param string $language The language (e.g., 'es-ES').
     * @return array An array of DTOMedia objects.
     */
    public function searchSeries(string $query, int $page = 1, string $language = 'es-ES'): array
    {
        $params = [
            'query' => $query,
            'include_adult' => false,
            'language' => $language,
            'page' => $page,
        ];

        $response = $this->get('search/tv', $params);

        $dtoMediaResults = [];
        if ($response && isset($response['results'])) {
            foreach ($response['results'] as $seriesData) {
                $dtoMediaResults[] = DTOMedia::create($seriesData);
            }
        }

        return $dtoMediaResults;
    }

    /**
     * Obtener temporadas de una serie de TV desde TMDB.
     *
     * @param int $seriesId El ID TMDB de la serie.
     * @param string $language El idioma (por ejemplo, 'es-ES').
     * @return array|null Un array con los datos de las temporadas o null si no se encuentran.
     */
    public function getSeriesSeasons(int $seriesId, string $language = 'es-ES'): ?array
    {
        $params = [
            'language' => $language,
        ];

        $response = $this->get("tv/{$seriesId}", $params);

        if ($response && isset($response['seasons'])) {
            return $response['seasons'];
        }

        return null;
    }
}
