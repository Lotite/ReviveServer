<?php

namespace App\Class;

use App\Class\Table;
use App\Database\BD;
use App\Models\UserList;
use PHPUnit\Framework\Constraint\IsEmpty;

class UserLists extends Table
{
    /**
     * Verifica si una variable es una instancia de UserLists.
     *
     * @param mixed $list Variable a verificar.
     * @return bool True si es instancia de UserLists, false en caso contrario.
     */
    public static function isUserListsList($list)
    {
        return $list instanceof UserLists;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $userListItem) {
                $userList = UserList::NewUserList($userListItem);
                $this->add($userList);
            }
        } elseif (self::isUserListsList($input)) {
            foreach ($input as $userList) {
                $this->add($userList);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $userList) {
                if (($userList instanceof UserList)) {
                    $this->add($userList);
                }
            }
        }
    }

    /**
     * Agrega un nuevo objeto UserList a la colección.
     *
     * @param UserList $userList Nuevo UserList a agregar.
     */
    public function add($userList)
    {
        parent::add($userList);
    }

    /**
     * Devuelve una lista de UserLists filtrados según el callback.
     *
     * @param callable(UserList): bool $callback Función para filtrar UserLists.
     * @return UserLists Nueva instancia de UserLists con los UserLists filtrados.
     */
    public function where(callable $callback): UserLists
    {
        return new UserLists(parent::where($callback));
    }

    /**
     * Devuelve el primer UserList que cumple la condición o null si no hay ninguno.
     *
     * @param callable(UserList): bool|null $callback Función para evaluar la condición.
     * @return UserList|null Primer UserList que cumple la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?UserList
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún UserList cumple la condición dada.
     *
     * @param callable(UserList): bool|null $callback Función para evaluar la condición.
     * @return bool True si algún UserList cumple la condición, false en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }

    public static function exist(int $userId, int $mediaId): bool
    {
        $conditions = [
            "user_id" => $userId,
            "media_id" => $mediaId
        ];
        return BD::existMultiple("UserList", $conditions);
    }


    /**
     * Convierte la colección de UserList a una colección de Medias.
     *
     * @return Medias Colección de Medias.
     */
    public function toMedias(): Medias
    {
        $medias = new Medias();
        foreach ($this as $userList) {
            $media = $userList->toMedia();
            if ($media) {
                $medias->add($media);
            }
        }
        return $medias;
    }


    /**
     * Obtiene la lista de UserList para un usuario específico.
     *
     * @param int $userId ID del usuario.
     * @return UserLists Colección de UserList.
     */
    public static function getUserList($userId)
    {
        $request = BD::getData("UserList", "*", ["user_id" => $userId]);
        if (empty($request)) {
            return new UserLists();
        }
        return new UserLists($request);
    }
}
