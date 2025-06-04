<?php

namespace App\Class;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class MediaStorageManager
{
    /**
     * Guarda el archivo de portada en el sistema de almacenamiento.
     *
     * @param UploadedFile $portadaFile Archivo de portada a guardar.
     * @param int $id ID del elemento multimedia (película, serie, etc.).
     * @return string|null Ruta del archivo guardado, o null si no se pudo guardar.
     */
    public static function savePoster(UploadedFile $portadaFile, int $id): ?string
    {
        if ($portadaFile ) {
            return Storage::putFileAs("public/media/{$id}", $portadaFile, "portada." . $portadaFile->getClientOriginalExtension());
        }

        return null;
    }

    /**
     * Guarda el archivo de banner en el sistema de almacenamiento.
     *
     * @param UploadedFile $bannerFile Archivo de banner a guardar.
     * @param int $id ID del elemento multimedia (película, serie, etc.).
     * @return string|null Ruta del archivo guardado, o null si no se pudo guardar.
     */
    public static function saveBanner(UploadedFile $bannerFile, int $id): ?string
    {
        if ($bannerFile ) {
            return Storage::putFileAs("public/media/{$id}", $bannerFile, "banner." . $bannerFile->getClientOriginalExtension());
        }

        return null;
    }

    /**
     * Guarda el archivo de video en el sistema de almacenamiento.
     *
     * @param UploadedFile $videoFile Archivo de video a guardar.
     * @param int $id ID del elemento multimedia (película, serie, etc.).
     * @return string|null Ruta del archivo guardado, o null si no se pudo guardar.
     */
    public static function saveVideo(UploadedFile $videoFile, int $id): ?string
    {
        if ($videoFile ) {
            try {
                return Storage::putFileAs("public/media/{$id}", $videoFile, "video." . $videoFile->getClientOriginalExtension());
            } catch (\Exception $e) {
                \Log::error("Error saving video: " . $e->getMessage());
                return null;
            }
        } else {
            \Log::error("Error uploading video: " . $videoFile->getError());
        }

        return null;
    }
}
