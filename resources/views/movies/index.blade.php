<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Película</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Añadir Nueva Película</h2>

        <!-- TMDB Movie Search -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Buscar Película en TMDB</h3>
            <div class="flex space-x-4">
                <input type="text" id="tmdb_search_input"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Introduce el título de la película" />
                <button type="button" id="tmdb_search_button"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                    Buscar
                </button>
            </div>
            <div id="tmdb_search_results" class="mt-4 border border-gray-300 rounded-md max-h-60 overflow-y-auto hidden">
                <!-- TMDB search results will be loaded here -->
            </div>
        </div>

        <form action="/movies" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-gray-700 text-sm font-semibold mb-2">Título</label>
                <input type="text" id="title" name="title"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Título de la película" />
            </div>

            <div>
                <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">Descripción</label>
                <textarea id="description" name="description" rows="4"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Breve descripción de la película..."></textarea>
            </div>

            <div>
                <label for="release_date" class="block text-gray-700 text-sm font-semibold mb-2">Fecha de
                    lanzamiento</label>
                <input type="date" id="release_date" name="release_date"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
            </div>

            <div>
                <label for="duration" class="block text-gray-700 text-sm font-semibold mb-2">Duración (minutos)</label>
                <input type="number" id="duration" name="duration"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Ej. 120" />
            </div>

            <div>
                <label for="tmdb_id" class="block text-gray-700 text-sm font-semibold mb-2">TMDB ID</label>
                <input type="number" id="tmdb_id" name="tmdb_id"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="ID de TMDB" />
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Géneros</label>
                <div class="flex flex-wrap -mx-2">
                    <?php
use App\Class\Generos;
$generos = Generos::getGeneros();
                    ?>
                    <?php foreach ($generos as $genero): ?>
                    <div class="px-2 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="generos[]" value="<?php    echo $genero->id; ?>"
                                class="form-checkbox text-blue-600">
                            <span class="ml-2 text-gray-700 text-sm"><?php    echo $genero->nombre_genero; ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <label for="contributor_search" class="block text-gray-700 text-sm font-semibold mb-2">Buscar Contribuidor</label>
                <input type="text" id="contributor_search"
                    class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                    placeholder="Buscar por nombre de contribuidor" />
                <div id="contributor_results" class="mt-2 border border-gray-300 rounded-md max-h-40 overflow-y-auto hidden">
                    <!-- Search results will be loaded here -->
                </div>
                <div id="selected_contributors" class="mt-2 flex flex-wrap gap-2">
                    <!-- Selected contributors will be displayed here -->
                </div>
                <input type="hidden" name="contributor_ids" id="contributor_ids" value="">
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

            <div>
                <label for="video" class="block text-gray-700 text-sm font-semibold mb-2">Video</label>
                <input type="file" id="video" name="video" accept="video/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">
                Añadir Película
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

            <?php if (isset($videoUrl)): ?>
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Video Actual</h3>
                <video src="<?php    echo $videoUrl; ?>" width="320" height="240" controls
                    class="mx-auto rounded-lg shadow-md border border-gray-200 bg-black"></video>
            </div>
            <?php endif; ?>
        </div>

        <div
            class="mt-8 text-center flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <img id="portada-preview" src="#" alt="Vista previa de la portada"
                class="hidden max-w-xs mx-auto rounded-lg shadow-md border border-gray-200 object-cover">
            <img id="banner-preview" src="#" alt="Vista previa del banner"
                class="hidden max-w-xs mx-auto rounded-lg shadow-md border border-gray-200 object-cover">
            <video id="video-preview" width="320" height="240" controls
                class="hidden mx-auto rounded-lg shadow-md border border-gray-200 bg-black"></video>
        </div>
    </div>

    <script>
        const portadaInput = document.getElementById('portada');
        const portadaPreview = document.getElementById('portada-preview');
        const bannerInput = document.getElementById('banner');
        const bannerPreview = document.getElementById('banner-preview');
        const videoInput = document.getElementById('video');
        const videoPreview = document.getElementById('video-preview');

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

        function handleVideoPreview(inputElement, previewElement) {
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
        handleVideoPreview(videoInput, videoPreview);

    </script>

    <script>
        const contributorSearchInput = document.getElementById('contributor_search');
        const contributorResultsDiv = document.getElementById('contributor_results');
        const selectedContributorsDiv = document.getElementById('selected_contributors');
        const contributorIdsInput = document.getElementById('contributor_ids');

        const selectedContributorIds = new Set();

        contributorSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();

            if (searchTerm.length > 2) { // Only search if more than 2 characters are typed
                fetch(`/api/contributors/search?name=${searchTerm}`) // Assuming an API endpoint for searching contributors
                    .then(response => response.json())
                    .then(data => {
                        displayContributorResults(data);
                    })
                    .catch(error => {
                        console.error('Error fetching contributors:', error);
                        contributorResultsDiv.innerHTML = '<div class="p-2 text-red-500">Error searching for contributors.</div>';
                        contributorResultsDiv.classList.remove('hidden');
                    });
            } else {
                contributorResultsDiv.innerHTML = '';
                contributorResultsDiv.classList.add('hidden');
            }
        });

        function displayContributorResults(contributors) {
            contributorResultsDiv.innerHTML = '';
            if (contributors.length > 0) {
                contributors.forEach(contributor => {
                    const resultElement = document.createElement('div');
                    resultElement.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                    resultElement.textContent = contributor.name + (contributor.role ? ` (${contributor.role})` : '');
                    resultElement.dataset.contributorId = contributor.id;
                    resultElement.dataset.contributorName = contributor.name;
                    resultElement.dataset.contributorRole = contributor.role || '';

                    resultElement.addEventListener('click', function() {
                        addContributor(this.dataset.contributorId, this.dataset.contributorName, this.dataset.contributorRole);
                        contributorResultsDiv.innerHTML = '';
                        contributorResultsDiv.classList.add('hidden');
                        contributorSearchInput.value = '';
                    });

                    contributorResultsDiv.appendChild(resultElement);
                });
                contributorResultsDiv.classList.remove('hidden');
            } else {
                contributorResultsDiv.innerHTML = '<div class="p-2 text-gray-500">No contributors found.</div>';
                contributorResultsDiv.classList.add('hidden');
            }
        }

        function addContributor(id, name, role) {
            if (!selectedContributorIds.has(id)) {
                selectedContributorIds.add(id);

                const selectedElement = document.createElement('span');
                selectedElement.classList.add('inline-flex', 'items-center', 'bg-blue-100', 'text-blue-800', 'text-sm', 'font-medium', 'px-2.5', 'py-0.5', 'rounded-full');
                selectedElement.textContent = name + (role ? ` (${role})` : '');

                const removeButton = document.createElement('button');
                removeButton.classList.add('ml-1', 'inline-flex', 'items-center', 'justify-center', 'w-4', 'h-4', 'text-blue-400', 'hover:text-blue-600', 'rounded-full', 'focus:outline-none');
                removeButton.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                removeButton.addEventListener('click', function() {
                    removeContributor(id, selectedElement);
                });

                selectedElement.appendChild(removeButton);
                selectedContributorsDiv.appendChild(selectedElement);

                updateContributorIdsInput();
            }
        }

        function removeContributor(id, element) {
            selectedContributorIds.delete(id);
            element.remove();
            updateContributorIdsInput();
        }

        function updateContributorIdsInput() {
            contributorIdsInput.value = Array.from(selectedContributorIds).join(',');
        }
    </script>

    <script>
        const tmdbSearchInput = document.getElementById('tmdb_search_input');
        const tmdbSearchButton = document.getElementById('tmdb_search_button');
        const tmdbSearchResultsDiv = document.getElementById('tmdb_search_results');

        tmdbSearchButton.addEventListener('click', function() {
            const query = tmdbSearchInput.value.trim();

            if (query.length > 2) {
                // Make an AJAX request to the backend to search TMDB
                fetch(`/api/tmdb/search/movies?query=${encodeURIComponent(query)}`) // Assuming a backend route /api/tmdb/search/movies
                    .then(response => response.json())
                    .then(data => {
                        displayTmdbSearchResults(data);
                    })
                    .catch(error => {
                        console.error('Error searching TMDB:', error);
                        tmdbSearchResultsDiv.innerHTML = '<div class="p-2 text-red-500">Error searching for movies.</div>';
                        tmdbSearchResultsDiv.classList.remove('hidden');
                    });
            } else {
                tmdbSearchResultsDiv.innerHTML = '';
                tmdbSearchResultsDiv.classList.add('hidden');
            }
        });

        function displayTmdbSearchResults(results) {
            tmdbSearchResultsDiv.innerHTML = '';
            if (results.length > 0) {
                results.forEach(movie => {
                    const resultElement = document.createElement('div');
                    resultElement.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200', 'flex', 'items-center');
                    resultElement.dataset.movieId = movie.id;
                    resultElement.dataset.movieTitle = movie.title;
                    resultElement.dataset.movieOverview = movie.description;
                    resultElement.dataset.movieReleaseDate = movie.date;
                    resultElement.dataset.moviePoster = movie.portada;
                    resultElement.dataset.movieBanner = movie.banner;

                    let imageUrl = movie.portada;
                    if (imageUrl && imageUrl.startsWith('https://image.tmdb.org/')) {
                         // Use a smaller size for the thumbnail in search results
                         imageUrl = imageUrl.replace('/w1280/', '/w92/');
                    } else {
                        // Use a placeholder if no image is available
                        imageUrl = 'https://via.placeholder.com/92x138?text=No+Image';
                    }


                    resultElement.innerHTML = `
                        <img src="${imageUrl}" alt="${movie.title}" class="w-12 h-18 object-cover rounded-md mr-4">
                        <div>
                            <div class="font-semibold">${movie.title}</div>
                            <div class="text-sm text-gray-600">${movie.date ? new Date(movie.date).getFullYear() : 'N/A'}</div>
                        </div>
                    `;


                    resultElement.addEventListener('click', function() {
                        populateFormWithMovieData(this.dataset);
                        tmdbSearchResultsDiv.innerHTML = '';
                        tmdbSearchResultsDiv.classList.add('hidden');
                    });

                    tmdbSearchResultsDiv.appendChild(resultElement);
                });
                tmdbSearchResultsDiv.classList.remove('hidden');
            } else {
                tmdbSearchResultsDiv.innerHTML = '<div class="p-2 text-gray-500">No movies found.</div>';
                tmdbSearchResultsDiv.classList.add('hidden');
            }
        }

        function populateFormWithMovieData(movieData) {
            document.getElementById('tmdb_id').value = movieData.movieId;
            document.getElementById('title').value = movieData.movieTitle;
            document.getElementById('description').value = movieData.movieOverview;
            document.getElementById('release_date').value = movieData.movieReleaseDate;

            // Select genres based on TMDB genre IDs
            const tmdbGenreIds = JSON.parse(movieData.generos); // Assuming generos is a JSON string of IDs
            const genreCheckboxes = document.querySelectorAll('input[name="generos[]"]');

            genreCheckboxes.forEach(checkbox => {
                if (tmdbGenreIds.includes(parseInt(checkbox.value))) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false; // Deselect if not in TMDB genres
                }
            });


            // Note: Handling image files from URL requires backend processing or a different approach
            // For now, we'll just display the image URLs if needed or handle separately.
            // The current file inputs are for uploading local files.
            console.log("Poster URL:", movieData.moviePoster);
            console.log("Banner URL:", movieData.movieBanner);

            // You might want to add logic here to fetch genres and contributors based on TMDB ID
        }
    </script>

    <?php
use App\Class\Movies;
use App\Models\GeneroMedia;
use App\Models\Credit;
use App\Class\MediaStorageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

$portadaUrl = null;
$bannerUrl = null;
$videoUrl = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $post = $_POST;
    $post["type"] = "movie";
    $movie = Movies::create($post);

        if ($movie) {
            $id = $movie;

            if (isset($_POST['generos']) && is_array($_POST['generos'])) {
                GeneroMedia::associateMediaWithGenres($id, $_POST['generos']);
            }

            // Associate contributors with the movie
            if (isset($_POST['contributor_ids']) && !empty($_POST['contributor_ids'])) {
                $contributorIds = explode(',', $_POST['contributor_ids']);
                Credit::associateMediaWithContributors($id, $contributorIds);
            }

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

        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $videoPath = MediaStorageManager::saveVideo(new UploadedFile(
                $_FILES['video']['tmp_name'],
                $_FILES['video']['name'],
                $_FILES['video']['type'],
                $_FILES['video']['size'],
                $_FILES['video']['error']
            ), $id);
            $videoUrl = $videoPath ? Storage::url($videoPath) : null;
        }
    }
}
    ?>
</body>

</html>
