<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TmdbService;
use Illuminate\Http\Request;

class TmdbController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    /**
     * Buscar películas usando el servicio TMDB.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchMovies(Request $request)
    {
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query parameter is required.'], 400);
        }

        $movies = $this->tmdbService->searchMovies($query);

        return response()->json($movies);
    }

    /**
     * Buscar series de TV usando el servicio TMDB.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchSeries(Request $request)
    {
        $query = $request->query('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query parameter is required.'], 400);
        }

        $series = $this->tmdbService->searchSeries($query);

        return response()->json($series);
    }

    /**
     * Obtener temporadas de una serie de TV usando el servicio TMDB.
     *
     * @param Request $request
     * @param int $seriesId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSeriesSeasons(Request $request, int $seriesId)
    {
        $language = $request->query('language', 'es-ES'); 

        $seasons = $this->tmdbService->getSeriesSeasons($seriesId, $language);

        if (is_null($seasons)) {
            return response()->json(['error' => 'Series or seasons not found.'], 404);
        }

        return response()->json($seasons);
    }
}
