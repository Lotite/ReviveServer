<?php

use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\callback;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return "hola";
});

Route::match(['get', 'post'], "/movies", function () {
    return view('movies.index');
});

Route::get('/media/{id}/{filename}', function ($id, $filename) {
    $path = storage_path("app/public/media/{$id}/{$filename}");

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $headers = [
        'Content-Type' => $type,
        'Accept-Ranges' => 'bytes',
    ];

    if (isset($_SERVER['HTTP_RANGE'])) {
        $range = $_SERVER['HTTP_RANGE'];
        list($bytes, $range) = explode('=', $range, 2);
        list($start, $end) = explode('-', $range, 2);
        $start = (int)$start;
        $end = $end ? (int)$end : filesize($path) - 1;
        $length = $end - $start + 1;

        $file = fopen($path, 'r');
        fseek($file, $start);
        $fileData = fread($file, $length);
        fclose($file);

        $headers['Content-Length'] = $length;
        $headers['Content-Range'] = "bytes {$start}-{$end}/" . filesize($path);

        $response = Response::make($fileData, 206, $headers);
    } else {
        $headers['Content-Length'] = filesize($path);
        $response = Response::make(File::get($path), 200, $headers);
    }

    return $response;
});
