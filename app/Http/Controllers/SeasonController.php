<?php

namespace App\Http\Controllers;

use App\Class\MediaStorageManager;
use Illuminate\Http\Request;
use App\Class\Seasons;

class SeasonController extends Controller
{
    public function index()
    {
        return view('seasons.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'series_id' => 'required|integer',
            'title' => 'required',
            'description' => 'required',
            'release_date' => 'required|date',
            'tmdb_id' => 'required|integer',
            'season_number' => 'required|integer',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $season = Seasons::create([
            'series_id' => $request->input('series_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'season_number' => $request->input('season_number'),
            'description' => $request->input('description'),
            'release_date' => $request->input('release_date'),
            'tmdb_id' => $request->input('tmdb_id'),
        ]);

        if ($season) {
            $id = $season["id_media"];

            $portadaPath = null;
            $bannerPath = null;

            if ($request->hasFile('portada')) {
                $portadaPath = MediaStorageManager::savePoster($request->file('portada'), $id);
            }

            if ($request->hasFile('banner')) {
                $bannerPath = MediaStorageManager::saveBanner($request->file('banner'), $id);
            }

            return redirect('/seasons')->with([
                'portadaUrl' => $portadaPath ? asset('storage/' . $portadaPath) : null,
                'bannerUrl' => $bannerPath ? asset('storage/' . $bannerPath) : null,
            ]);
        } else {
            return redirect('/seasons')->with('error', 'Failed to create season.');
        }
    }
}
