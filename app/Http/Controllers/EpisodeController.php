<?php

namespace App\Http\Controllers;

use App\Class\MediaStorageManager;
use Illuminate\Http\Request;
use App\Class\Episodes;

class EpisodeController extends Controller
{
    public function index()
    {
        return view('episodes.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'season_id' => 'required|integer',
            'title' => 'required',
            'description' => 'required',
            'release_date' => 'required|date',
            'tmdb_id' => 'required|integer',
            'duration' => 'required|integer',
            'episode_number' => 'required|integer',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $episode = Episodes::create([
            'season_id' => $request->input('season_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'duration' => $request->input('duration'),
            'episode_number' => $request->input('episode_number'),
            'release_date' => $request->input('release_date'),
            'tmdb_id' => $request->input('tmdb_id'),
        ]);

        if ($episode) {
            $id = $episode["id_media"];

            $portadaPath = null;
            $videoPath = null;

            if ($request->hasFile('portada')) {
                $portadaPath = MediaStorageManager::savePoster($request->file('portada'), $id);
            }

            if ($request->hasFile('video')) {
                $videoPath = MediaStorageManager::saveVideo($request->file('video'), $id);
            }

            return redirect('/episodes')->with([
                'portadaUrl' => $portadaPath ? asset('storage/' . $portadaPath) : null,
                'videoUrl' => $videoPath ? asset('storage/' . $videoPath) : null,
            ]);
        } else {
            return redirect('/episodes')->with('error', 'Failed to create episode.');
        }
    }
}
