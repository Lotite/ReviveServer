<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Película</title>
    <!-- Incluye Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Puedes añadir estilos personalizados aquí si es necesario */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Título</label>
            <input type="text" id="title" name="title"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Descripción</label>
            <textarea id="description" name="description"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="mb-4">
            <label for="release_date" class="block text-gray-700 font-bold mb-2">Fecha de lanzamiento</label>
            <input type="date" id="release_date" name="release_date"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-4">
            <label for="duration" class="block text-gray-700 font-bold mb-2">Duracion</label>
            <input type="number" id="duration" name="duration"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-4">
            <label for="tmdb_id" class="block text-gray-700 font-bold mb-2">TMDB ID</label>
            <input type="number" id="tmdb_id" name="tmdb_id"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-4">
            <label for="portada" class="block text-gray-700 font-bold mb-2">Portada</label>
            <input type="file" id="portada" name="portada" accept="image/*"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-4">
            <label for="banner" class="block text-gray-700 font-bold mb-2">Banner</label>
            <input type="file" id="banner" name="banner" accept="image/*"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div class="mb-4">
            <label for="video" class="block text-gray-700 font-bold mb-2">Video</label>
            <input type="file" id="video" name="video" accept="video/*"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <input type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer" />
    </form>

    <?php if (isset($portadaUrl)): ?>
        <div class="mt-4">
            <img src="<?php echo $portadaUrl; ?>" alt="Portada" class="max-w-sm">
        </div>
    <?php endif; ?>

    <?php if (isset($bannerUrl)): ?>
        <div class="mt-4">
            <img src="<?php echo $bannerUrl; ?>" alt="Banner" class="max-w-md">
        </div>
    <?php endif; ?>

    <?php if (isset($videoUrl)): ?>
        <div class="mt-4">
            <video width="320" height="240" controls>
                <source src="<?php echo $videoUrl; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    <?php endif; ?>
</body>

</html>

<?php
use App\Class\Movies;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $post = $_POST;
    $post["type"] = "movie";
    $movie = Movies::create($post);

    if ($movie) {
        $id = $movie;

        $portada = $_FILES['portada'] ?? null;
        $banner = $_FILES['banner'] ?? null;
        $video = $_FILES['video'] ?? null;

        if ($portada && $portada['error'] === UPLOAD_ERR_OK) {
            $portadaFile = new UploadedFile(
                $portada['tmp_name'],
                $portada['name'],
                $portada['type'],
                $portada['error']
            );
            $portadaPath = Storage::putFileAs("public/media/{$id}", $portadaFile, "portada." . $portadaFile->getClientOriginalExtension());
        }

        if ($banner && $banner['error'] === UPLOAD_ERR_OK) {
            $bannerFile = new UploadedFile(
                $banner['tmp_name'],
                $banner['name'],
                $banner['type'],
                $banner['error']
            );
            $bannerPath = Storage::putFileAs("public/media/{$id}", $bannerFile, "banner." . $bannerFile->getClientOriginalExtension());
        }

        if ($video && $video['error'] === UPLOAD_ERR_OK) {
            $videoFile = new UploadedFile(
                $video['tmp_name'],
                $video['name'],
                $video['type'],
                $video['error']
            );
            $videoPath = Storage::putFileAs("public/media/{$id}", $videoFile, "video." . $videoFile->getClientOriginalExtension());
        }
    }
}

$portadaUrl = isset($portadaPath) ? Storage::url($portadaPath) : null;
$bannerUrl = isset($bannerPath) ? Storage::url($bannerPath) : null;
$videoUrl = isset($videoPath) ? Storage::url($videoPath) : null;
?>
