<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Episodio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>


<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Añadir Nuevo Episodio</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="season_id" class="block text-gray-700 text-sm font-semibold mb-2">ID de Temporada</label>
                <input type="number" id="season_id" name="season_id"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Ej. 1" />
            </div>

            <div>
                <label for="title" class="block text-gray-700 text-sm font-semibold mb-2">Título</label>
                <input type="text" id="title" name="title"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Título del episodio" />
            </div>

            <div>
                <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">Descripción</label>
                <textarea id="description" name="description" rows="4"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Breve descripción del episodio..."></textarea>
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
                <label for="duration" class="block text-gray-700 text-sm font-semibold mb-2">Duración (minutos)</label>
                <input type="number" id="duration" name="duration"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Ej. 45" />
            </div>
            <div>
                <label for="episode_number" class="block text-gray-700 text-sm font-semibold mb-2">Número de
                    Episodio</label>
                <input type="number" id="episode_number" name="episode_number"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Ej. 1" />
            </div>
            <div>
                <label for="video" class="block text-gray-700 text-sm font-semibold mb-2">Video</label>
                <input type="file" id="video" name="video" accept="video/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
            </div>
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                Añadir Episodio
            </button>
        </form>
        <?php if (isset($portadaUrl)): ?>
        <div class="mt-8 text-center">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Portada Actual</h3>
            <img src="<?php    echo $portadaUrl; ?>" alt="Portada"
                class="max-w-xs mx-auto rounded-lg shadow-md border border-gray-200">
        </div>
        <?php endif; ?>

        <div
            class="mt-8 text-center flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <img id="portada-preview" src="#" alt="Vista previa de la portada"
                class="hidden max-w-xs mx-auto rounded-lg shadow-md border border-gray-200 object-cover">
            <video id="video-preview" width="320" height="240" controls
                class="hidden mx-auto rounded-lg shadow-md border border-gray-200 bg-black"></video>
        </div>
    </div>

    <script>
        const portadaInput = document.getElementById('portada');
        const portadaPreview = document.getElementById('portada-preview');
        const videoInput = document.getElementById('video');
        const videoPreview = document.getElementById('video-preview');

        portadaInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader(); /
                portadaPreview.classList.remove('hidden');
                reader.addEventListener('load', function () {
                    console.log('Portada loaded');
                    portadaPreview.setAttribute('src', this.result);
                });

                reader.readAsDataURL(file);
                console.log('Portada file read');
            } else {
                portadaPreview.setAttribute('src', '#');
                portadaPreview.classList.add('hidden');
                console.log('No portada file selected');
            }
        });

        videoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                videoPreview.classList.remove('hidden');

                reader.addEventListener('load', function () {
                    videoPreview.setAttribute('src', this.result);
                });

                reader.readAsDataURL(file);
            } else {
                videoPreview.setAttribute('src', '#');
                videoPreview.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
