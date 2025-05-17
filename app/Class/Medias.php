<?php

namespace App\Class;

use App\Class\Table;
use App\Models\Media;

class Medias extends Table
{
    /**
     * Checks if a variable is an instance of Medias.
     *
     * @param mixed $list Variable to check.
     * @return bool True if instance of Medias, false otherwise.
     */
    public static function isMediasList($list)
    {
        return $list instanceof Medias;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $mediaItem) {
                $media = Media::NewMedia($mediaItem);
                $this->add($media);
            }
        } elseif (self::isMediasList($input)) {
            foreach ($input as $media) {
                $this->add($media);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $media) {
                if (($media instanceof Media)) {
                    $this->add($media);
                }
            }
        }
    }

    /**
     * Adds a new Media object to the collection.
     *
     * @param Media $media New media to add.
     */
    public function add($media)
    {
        parent::add($media);
    }

    /**
     * Returns a filtered list of media according to the callback.
     *
     * @param callable(Media): bool $callback Filter function.
     * @return Medias New instance of Medias with filtered media.
     */
    public function where(callable $callback): Medias
    {
        return new Medias(parent::where($callback));
    }

    /**
     * Returns the first media that matches the condition or null if none.
     *
     * @param callable(Media): bool|null $callback Condition function.
     * @return Media|null First media matching condition or null.
     */
    public function firstOrNull(?callable $callback = null): ?Media
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Checks if any media matches the given condition.
     *
     * @param callable(Media): bool|null $callback Condition function.
     * @return bool True if any media matches, false otherwise.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }
}
