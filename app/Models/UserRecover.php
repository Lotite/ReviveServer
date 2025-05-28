<?php

namespace App\Models;

use App\Database\BD;
use DateTime;
use Dotenv\Parser\Parser;

class UserRecover
{
    public string $email;
    public string $token;
    public string $code;
    public DateTime $expires_at;

    public function __construct(string $email, string $token, string $code, DateTime $expires_at)
    {
        $this->email = $email;
        $this->token = $token;
        $this->code = $code;
        $this->expires_at = $expires_at;
    }

    /**
     * Crea una nueva instancia de UserRecover a partir de un array de datos.
     *
     * @param array $data Datos de recuperación de usuario.
     * @return UserRecover Nueva instancia de UserRecover.
     */
    public static function NewUserRecover(array $data)
    {
        $expiresAt = DateTime::createFromFormat('Y-m-d H:i:s', $data["expires_at"]);
        return new UserRecover($data['email'], $data['token'], $data['code'], $expiresAt);
    }

    /**
     * Crea una nueva entrada de recuperación de usuario en la base de datos.
     *
     * @param string $email Email del usuario.
     * @param string $token Token único.
     * @param string $code Código de verificación.
     * @param DateTime $expires_at Fecha y hora de expiración.
     * @return bool True si la operación es exitosa, false si falla.
     */
    public static function createNewUserRecover(string $email, string $token, string $code, DateTime $expires_at)
    {
        $data = [
            "email" => $email,
            "token" => $token,
            "code" => $code,
            "expires_at" => $expires_at->format('Y-m-d H:i:s')
        ];

        return BD::InsertIntoTable("user_recover", $data);
    }

    /**
     * Obtiene una entrada de recuperación de usuario por token.
     *
     * @param string $token El token a buscar.
     * @return UserRecover|null Instancia de UserRecover o null si no se encuentra.
     */
    public static function getByToken(string $token): ?UserRecover
    {
        $userRecover = BD::getFirstRow("user_recover", "*", ["token" => $token]);
        if ($userRecover) {
            return self::NewUserRecover($userRecover);
        }
        return null;
    }

    /**
     * Obtiene una entrada de recuperación de usuario por email.
     *
     * @param string $email El email a buscar.
     * @return UserRecover|null Instancia de UserRecover o null si no se encuentra.
     */
    public static function getByEmail(string $email): ?UserRecover
    {
        $userRecover = BD::getFirstRow("user_recover", "*", ["email" => $email]);
        if ($userRecover) {
            return self::NewUserRecover($userRecover);
        }
        return null;
    }

    /**
     * Elimina una entrada de recuperación de usuario por token.
     *
     * @param string $token El token a eliminar.
     * @return bool True si la operación es exitosa, false si falla.
     */
    public static function deleteByToken(string $token): bool
    {
        return BD::DeleteFromTable("user_recover", "token", (int)$token);
    }

    /**
     * Elimina una entrada de recuperación de usuario por email.
     *
     * @param string $email El email a eliminar.
     * @return bool True si la operación es exitosa, false si falla.
     */
    public static function deleteByEmail(string $email): bool
    {
        $userRecover = self::getByEmail($email);
        if ($userRecover) {
            return BD::DeleteFromTable("user_recover", "token", (int)$userRecover->getToken());
        }
        return false;
    }

    /**
     * Comprueba si existe una entrada de recuperación de usuario para el token dado.
     *
     * @param string $token El token a comprobar.
     * @return bool True si existe, false en caso contrario.
     */
    public static function exists(string $token): bool
    {
        return BD::exist("token", $token, "user_recover");
    }

    /**
     * Comprueba si existe una entrada de recuperación de usuario para el email dado.
     *
     * @param string $email El email a comprobar.
     * @return bool True si existe, false en caso contrario.
     */
    public static function existsEmail(string $email): bool
    {
        return BD::exist("email", $email, "user_recover");
    }

    /**
     * Obtiene la dirección de correo electrónico.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Obtiene el token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Obtiene el código.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Obtiene la fecha y hora de expiración.
     *
     * @return DateTime
     */
    public function getExpiresAt(): DateTime
    {
        return $this->expires_at;
    }
}
