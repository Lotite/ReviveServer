<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Serie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Añadir Nueva Serie</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-gray-700 text-sm font-semibold mb-2">Título</label>
                <input type="text" id="title" name="title"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Título de la serie" />
            </div>

            <div>
                <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">Descripción</label>
                <textarea id="description" name="description" rows="4"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Breve descripción de la serie..."></textarea>
            </div>

            <div>
                <label for="release_date" class="block text-gray-700 text-sm font-semibold mb-2">Fecha de
                    lanzamiento</label>
                <input type="date" id="release_date" name="release_date"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
            </div>

            <div>
                <label for="tmdb_id" class="block text-gray-700 text-sm font-semibold mb-2">TMDB ID</label>
                <input type="number" id="tmdb_id" name="tmdb_id"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="ID de TMDB" />
            </div>

            <div>
                <label for="portada" class="block text-gray-700 text-sm font-semibold mb-2">Portada</label>
                <input type="file" id="portada" name="portada" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
            </div>

            <div>
                <label for="banner" class="block text-gray-700 text-sm font-semibold mb-2">Banner</label>
                <input type="file" id="banner" name="banner" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                Añadir Serie
            </button>
        </form>

        <div class="mt-8 text-center">
            <?php if (isset($portadaUrl)): ?>
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Portada Actual</h3>
                <img src="<?php    echo $portadaUrl; ?>" alt="Portada"
                    class="max-w-xs mx-auto rounded-lg shadow-md border border-gray-200 object-cover">
            </div>
            <?php endif; ?>

            <?php if (isset($bannerUrl)): ?>
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Banner Actual</h3>
                <img src="<?php    echo $bannerUrl; ?>" alt="Banner"
                    class="max-w-xs mx-auto rounded-lg shadow-md border border-gray-200 object-cover">
            </div>
            <?php endif; ?>
        </div>

        <div
            class="mt-8 text-center flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <img id="portada-preview" src="#" alt="Vista previa de la portada"
                class="hidden max-w-xs mx-auto rounded-lg shadow-md border border-gray-200 object-cover">
            <img id="banner-preview" src="#" alt="Vista previa del banner"
                class="hidden max-w-xs mx-auto rounded-lg shadow-md border border-gray-200 object-cover">
        </div>
    </div>

    <script>
        const portadaInput = document.getElementById('portada');
        const portadaPreview = document.getElementById('portada-preview');
        const bannerInput = document.getElementById('banner');
        const bannerPreview = document.getElementById('banner-preview');

        function handleImagePreview(inputElement, previewElement) {
            inputElement.addEventListener('change', function () {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    previewElement.classList.remove('hidden');

                    reader.addEventListener('load', function () {
                        previewElement.setAttribute('src', this.result);
                    });

                    reader.readAsDataURL(file);
                } else {
                    previewElement.setAttribute('src', '#');
                    previewElement.classList.add('hidden');
                }
            });
        }

        handleImagePreview(portadaInput, portadaPreview);
        handleImagePreview(bannerInput, bannerPreview);

    </script>

    <?php
use App\Class\Series;
use App\Class\MediaStorageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

$portadaUrl = null;
$bannerUrl = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $post = $_POST;
    $serie = Series::create($post);

    if ($serie) {
        $id = $serie["id_media"] ?? null;

        if ($id) {
            if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
                $portadaPath = MediaStorageManager::savePoster(new UploadedFile(
                    $_FILES['portada']['tmp_name'],
                    $_FILES['portada']['name'],
                    $_FILES['portada']['type'],
                    $_FILES['portada']['size'],
                    $_FILES['portada']['error']
                ), $id);
                $portadaUrl = $portadaPath ? Storage::url($portadaPath) : null;
            }

            if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
                $bannerPath = MediaStorageManager::saveBanner(new UploadedFile(
                    $_FILES['banner']['tmp_name'],
                    $_FILES['banner']['name'],
                    $_FILES['banner']['type'],
                    $_FILES['banner']['size'],
                    $_FILES['banner']['error']
                ), $id);
                $bannerUrl = $bannerPath ? Storage::url($bannerPath) : null;
            }
        }
    }
}
?>
</body>

</html>