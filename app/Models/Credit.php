<?php

namespace App\Models;

use App\Database\BD;

class Credit
{
    public int $id;
    public string $name;
    public ?string $role;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->role = $data['role'] ?? null;
    }

    public static function NewCredit($data): Credit
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        return new Credit($data);
    }

    /**
     * Asocia una media con una lista de contribuidores.
     *
     * @param int $mediaId El ID de la media.
     * @param array $contributorIds Un array de IDs de contribuidores.
     * @return bool True si la asociación fue exitosa para todos los contribuidores, false en caso contrario.
     */
    public static function associateMediaWithContributors(int $mediaId, array $contributorIds): bool
    {
        if (empty($contributorIds)) {
            return true; // No contributors to associate
        }

        $success = true;
        foreach ($contributorIds as $contributorId) {
            $data = [
                'mediaID' => $mediaId,
                'ContributorID' => $contributorId,
            ];
            if (!BD::InsertIntoTable('creditos', $data)) {
                $success = false;
            }
        }
        return $success;
    }
}
