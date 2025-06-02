<?php

namespace App\Models;

use App\Database\BD;
use PHPUnit\Framework\Constraint\IsEmpty;

class UserList
{
    public int $id;
    public int $user_id;
    public int $media_id;

    public function __construct(?int $id = null, ?int $user_id = null, ?int $media_id = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->media_id = $media_id;
    }

    /**
     * Crea una nueva instancia de UserList a partir de un array de datos.
     *
     * @param array $data Datos del UserList.
     * @return UserList Nueva instancia de UserList.
     */
    public static function NewUserList(array $data)
    {
        return new UserList($data['id'], $data['user_id'], $data['media_id']);
    }

    /**
     * Obtiene un UserList por su ID.
     *
     * @param int $id ID del UserList a buscar.
     * @return UserList|null Instancia de UserList o null si no se encuentra.
     */
    public static function getUserList($media_id,$user_id): ?UserList
    {
        $userList = BD::getFirstRow("UserList", "*", ["media_id" => $media_id,"user_id"=> $user_id]);
        if ($userList) {
            return self::NewUserList($userList);
        }
        return null;
    }

    /**
     * Crea un nuevo UserList en la base de datos.
     *
     * @param array $data Datos para crear el UserList.
     * @return bool True si la creación fue exitosa, false en caso contrario.
     */
    public static function createNewUserList(array $data): bool
    {
        return BD::InsertIntoTable("UserList", $data);
    }

    /**
     * Elimina un UserList por su ID.
     *
     * @param int $userListId ID del UserList a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public static function deleteUserListById(int $userListId)
    {
        return BD::DeleteFromTable("UserList", "id", $userListId);
    }

    /**
     * Obtiene el objeto Media asociado a este UserList.
     *
     * @return Media|null
     */
    public function toMedia()
    {
        return Media::getMediaById($this->media_id);
    }
}
