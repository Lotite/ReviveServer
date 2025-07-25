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

Route::match(['get', 'post'], "/series", function () {
    return view('series.index');
});

use App\Http\Controllers\SeasonController;
Route::get('/seasons', [SeasonController::class, 'index']);
Route::post('/seasons', [SeasonController::class, 'store']);

use App\Http\Controllers\EpisodeController;
Route::get('/episodes', [EpisodeController::class, 'index']);
Route::post('/episodes', [EpisodeController::class, 'store']);




Route::get('/media/{id}/{filename}', function ($id, $filename) {
    $path = storage_path("app/public/media/{$id}/{$filename}");

    if (!File::exists($path)) {
        // Determinar el tipo de medio basado en el nombre del archivo o id
        $lowerFilename = strtolower($filename);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Verificar si es un video por la extensión
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv'];
        if (in_array($extension, $videoExtensions)) {
            // Retornar archivo de video por defecto si existe
            $defaultVideoPath = storage_path("app/public/media/video.mp4");
            if (File::exists($defaultVideoPath)) {
                $type = File::mimeType($defaultVideoPath);
                $headers = [
                    'Content-Type' => $type,
                    'Accept-Ranges' => 'bytes',
                    'Content-Length' => filesize($defaultVideoPath),
                ];
                $fileContent = File::get($defaultVideoPath);
                return Response::make($fileContent, 200, $headers);
            } else {
                abort(404);
            }
        }

        if (strpos($lowerFilename, 'banner') !== false) {
            $url = "https://picsum.photos/1000/700?random={$id}";
            return redirect($url);
        }

        if (strpos($lowerFilename, 'portada') !== false) {
            $url = "https://picsum.photos/700/1000?random={$id}";
            return redirect($url);
        }

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
