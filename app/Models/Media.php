<?php

namespace App\Models;

use App\Database\BD;
use DateTime;

require_once __DIR__ . "/../../database/database.php";

class Media
{
    public ?int $id;
    public ?string $title;
    public ?string $description;
    public ?DateTime $release_date;
    public ?int $tmdb_id;

    public function __construct(?int $id = null, ?string $title = null, ?string $description = null, ?DateTime $release_date = null, ?int $tmdb_id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->release_date = $release_date;
        $this->tmdb_id = $tmdb_id;
    }

    /**
     * Creates a new Media instance from an array of data.
     *
     * @param array $data Data array.
     * @return Media New Media instance.
     */
    public static function NewMedia(array $data)
    {
        $releaseDate = null;
        if (!empty($data["release_date"])) {
            $releaseDate = DateTime::createFromFormat('Y-m-d', $data["release_date"]);
        }
        return new Media(
            $data['id'] ?? null,
            $data['title'] ?? null,
            $data['description'] ?? null,
            $releaseDate,
            $data['tmdb_id'] ?? null
        );
    }

    /**
     * Creates a new media record in the database.
     *
     * @param array $data Data to create media.
     * @return void
     */
    public static function createNewMedia(array $data)
    {
        BD::InsertIntoTable("media", $data);
    }

    /**
     * Checks if a media with given ID exists.
     *
     * @param mixed $id Media ID.
     * @return bool True if exists, false otherwise.
     */
    public static function ExistsMediaId($id)
    {
        return is_int($id) && BD::exist("id", $id, "media");
    }

    /**
     * Updates a specific column of the media in the database.
     *
     * @param string $column Column name.
     * @param mixed $value New value.
     * @return void
     */
    public function Update(string $column, mixed $value)
    {
        if ($this->id !== null) {
            BD::UpdateTable("media", $column, $value, $this->id);
        }
    }

    // Getters and setters for each property

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
        $this->Update("title", $title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
        $this->Update("description", $description);
    }

    public function getReleaseDate(): ?DateTime
    {
        return $this->release_date;
    }

    public function setReleaseDate(?DateTime $release_date): void
    {
        $this->release_date = $release_date;
        $dateString = $release_date ? $release_date->format('Y-m-d') : null;
        $this->Update("release_date", $dateString);
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdb_id;
    }

    public function setTmdbId(?int $tmdb_id): void
    {
        $this->tmdb_id = $tmdb_id;
        $this->Update("tmdb_id", $tmdb_id);
    }
}
