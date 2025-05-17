<?php

namespace App\Models;

use App\Database\BD;
use DateTime;

class Device
{
    private ?int $id;

    private ?int $user_id;

    private ?string $device_name;

    private ?DateTime $last_active_timestamp;

    private ?string $token;

    private ?DateTime $register_at;


    public function __construct(?int $id = null, ?int $user_id, ?string $device_name, ?DateTime $last_active_timestamp = null, $token = null, ?DateTime $register_at = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->device_name = $device_name;
        $this->last_active_timestamp = $last_active_timestamp ?? new DateTime();
        $this->token = $token ?? bin2hex(random_bytes(32));
        $this->register_at = $register_at ?? new DateTime();
    }

    /**
     * Crea una nueva instancia de Device a partir de un array de datos.
     *
     * @param array $data Datos del dispositivo.
     * @return Device Nueva instancia de Device.
     */
    public static function NewDevice(array $data): Device
    {
        $lastActive = isset($data["last_active_timestamp"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $data["last_active_timestamp"]) : null;
        $register_at = isset($data["register_at"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $data["register_at"]) : null;
        return new Device(
            $data['id'],
            $data['user_id'],
            $data['device_name'],
            $lastActive,
            $data['token'],
            $register_at
        );
    }

    /**
     * Inserta un nuevo dispositivo en la base de datos.
     *
     * @param Device $device Dispositivo a insertar.
     * @return bool Resultado de la inserción.
     */
    public static function createNewDevice(Device $device): bool
    {
        $data = [
            "user_id" => $device->user_id,
            "device_name" => $device->device_name,
            "last_active_timestamp" => $device->last_active_timestamp->format('Y-m-d H:i:s'),
            "token" => $device->token,
            "register_at" => $device->register_at->format('Y-m-d H:i:s'),
        ];

        return BD::InsertIntoTable("devices", $data);
    }

    /**
     * Guarda el dispositivo en la sesión y establece una cookie para recordarlo.
     *
     * @return bool Resultado de la operación.
     */
    public function rememberDevice(): bool
    {
        session_start();
        $_SESSION['device_token'] = $this->token;
        $_SESSION['device_name'] = $this->device_name;
        return setcookie('device_token', $this->token, time() + (86400 * 30), "/");
    }

    /**
     * Obtiene un dispositivo por su token.
     * Nota: Se recomienda optimizar la consulta para evitar lentitud.
     *
     * @param string $token Token del dispositivo.
     * @return Device|null Instancia de Device o null si no se encuentra.
     */
    public static function getByToken(string $token): ?Device
    {
        $result = BD::getData("devices", "*", ["token" => $token]);
        if (empty($result)) {
            return null;
        }

        $deviceData = $result[0];
        $lastActiveTimestamp = $deviceData['last_active_timestamp'] ? new DateTime($deviceData['last_active_timestamp']) : null;
        $registerAt = $deviceData['register_at'] ? new DateTime($deviceData['register_at']) : null;

        return new Device(
            $deviceData['id'],
            $deviceData['user_id'],
            $deviceData['device_name'],
            $lastActiveTimestamp,
            $deviceData['token'],
            $registerAt
        );
    }

    /**
     * Actualiza un campo específico del dispositivo en la base de datos.
     *
     * @param string $column Nombre de la columna a actualizar.
     * @param mixed $value Nuevo valor.
     * @return void
     */
    public function Update(string $column, mixed $value)
    {
        if ($this->id !== null) {
            BD::UpdateTable("devices", $column, $value, $this->id);
        }
    }

    /**
     * Verifica si existe un dispositivo con un ID dado.
     *
     * @param int $id ID del dispositivo.
     * @return bool True si existe, false en caso contrario.
     */
    public static function ExistsDeviceId(int $id): bool
    {
        return BD::exist("id", $id, "devices");
    }

    /**
     * Obtiene un dispositivo por su ID.
     *
     * @param int $id ID del dispositivo.
     * @return Device|null Instancia de Device o null si no se encuentra.
     */
    public static function getDevice(int $id): ?Device
    {
        return BD::$Devices->firstOrNull(fn($device) => $device->id === $id);
    }

    // Getters y Setters mejorados

    /**
     * Obtiene el ID del dispositivo.
     *
     * @return int|null ID del dispositivo.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Establece el ID del dispositivo.
     *
     * @param int|null $id Nuevo ID.
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Obtiene el ID del usuario asociado.
     *
     * @return int|null ID del usuario.
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * Establece el ID del usuario asociado.
     *
     * @param int|null $user_id Nuevo ID de usuario.
     * @return void
     */
    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * Obtiene el nombre o tipo del dispositivo.
     *
     * @return string|null Nombre o tipo del dispositivo.
     */
    public function getDeviceType(): ?string
    {
        return $this->device_name;
    }

    /**
     * Establece el nombre o tipo del dispositivo.
     *
     * @param string|null $device_name Nuevo nombre o tipo.
     * @return void
     */
    public function setDeviceType(?string $device_name): void
    {
        $this->device_name = $device_name;
    }

    /**
     * Obtiene el timestamp de la última actividad.
     *
     * @return DateTime|null Timestamp de la última actividad.
     */
    public function getLastActiveTimestamp(): ?DateTime
    {
        return $this->last_active_timestamp;
    }

    /**
     * Establece el timestamp de la última actividad y actualiza la base de datos.
     *
     * @param DateTime|null $timestamp Nuevo timestamp.
     * @return void
     */
    public function setLastActiveTimestamp(?DateTime $timestamp): void
    {
        $this->last_active_timestamp = $timestamp;
        $this->Update("last_active_timestamp", $timestamp);
    }

    /**
     * Obtiene el token del dispositivo.
     *
     * @return string|null Token del dispositivo.
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Establece el token del dispositivo.
     *
     * @param string|null $token Nuevo token.
     * @return void
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * Obtiene el timestamp de registro del dispositivo.
     *
     * @return DateTime|null Timestamp de registro.
     */
    public function getRegisterAt(): ?DateTime
    {
        return $this->register_at;
    }

    /**
     * Establece el timestamp de registro del dispositivo.
     *
     * @param DateTime|null $register_at Nuevo timestamp de registro.
     * @return void
     */
    public function setRegisterAt(?DateTime $register_at): void
    {
        $this->register_at = $register_at;
    }

    /**
     * Obtiene el ID del usuario asociado a un token de dispositivo.
     *
     * @param string $token El token del dispositivo.
     * @return int|null El ID del usuario asociado, o null si no se encuentra el token.
     */
    public static function getUser(string $token): ?int
    {
        $device = self::getByToken($token);
        if ($device === null) {
            return null;
        }
        return $device->user_id;
    }
}

