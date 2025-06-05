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
     * Search for movies using the TMDB service.
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
     * Search for TV series using the TMDB service.
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
}
