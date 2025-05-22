<?php

namespace App\Models;

use App\Database\BD;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;

class Device
{
    private ?int $id;

    private ?int $user_id;

    private ?string $device_name;

    private ?string $last_active_timestamp;

    private ?string $token;

    private ?string $register_at;



    public function __construct(?int $id = null, ?int $user_id, ?string $device_name, ?string $last_active_timestamp = null, $token = null, ?string $register_at = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->device_name = $device_name;
        $this->token = $token ?? bin2hex(random_bytes(32));

        $timestamp = microtime(true);
        $fecha_actual = gmdate('Y-m-d H:i:s', $timestamp);
        
        $this->last_active_timestamp = $last_active_timestamp ?? $fecha_actual;
        $this->register_at = $register_at ?? $fecha_actual;
    }


    /**
     * Crea una nueva instancia de Device a partir de un array de datos.
     *
     * @param array $data Datos del dispositivo.
     * @return Device Nueva instancia de Device.
     */
    public static function NewDevice(array $data): Device
    {

        return new Device(
            $data['id'] ?? null,
            $data['user_id'] ?? null,
            $data['device_name'] ?? null,
            $data["last_active_timestamp"] ?? null,
            $data['token'] ?? null,
            $data["register_at"] ?? null
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
            "last_active_timestamp" => $device->last_active_timestamp,
            "token" => $device->token,
            "register_at" => $device->register_at,
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
        $deviceData = BD::getFirstRow("devices", "*", ["token" => $token]);
        if (!$deviceData) {
            return null;
        }

        return new Device(
            $deviceData['id'],
            $deviceData['user_id'],
            $deviceData['device_name'],
            $deviceData['last_active_timestamp'],
            $deviceData['token'],
            $deviceData['register_at']
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
        $deviceData = BD::getFirstRow("devices", "*", ["id" => $id]);
        if (!$deviceData) {
            return null;
        }
        return self::NewDevice($deviceData);
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
    public function getLastActiveTimestamp(): ?string
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
    public function getRegisterAt(): ?string
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

    /**
     * Elimina todos los dispositivos asociados a un usuario excepto el dispositivo con el token especificado.
     *
     * @param int $userId ID del usuario.
     * @param string $exceptToken Token del dispositivo que no debe eliminarse.
     * @return bool Resultado de la operación.
     */
    public static function deleteAllExcept(string $userId, string $exceptToken): bool
    {
        return BD::execute(
            "DELETE FROM devices WHERE user_id = ? AND token != ?",
            [$userId, $exceptToken]
        );
    }

    /**
     * Obtiene todos los dispositivos asociados a un usuario.
     *
     * @param int $userId ID del usuario.
     * @return Device[] Array de instancias de Device.
     */
    public static function getDevicesByUserId(int $userId): array
    {
        $devicesData = BD::getData("devices", "*", ["user_id" => $userId]);
        $devices = [];
        foreach ($devicesData as $deviceData) {
            $device = self::NewDevice($deviceData);
            $devices[] = $device;
        }
        return $devices;
    }

    /**
     * Elimina un dispositivo dado su ID y el ID del usuario propietario.
     *
     * @param int $userId ID del usuario.
     * @param int $deviceId ID del dispositivo a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public static function deleteDevice(int $userId, int $deviceId): bool
    {
        // Verificar que el dispositivo pertenece al usuario
        $device = self::getDevice($deviceId);
        if ($device === null || $device->getUserId() !== $userId) {
            return false;
        }

        // Ejecutar la eliminación
        return BD::execute(
            "DELETE FROM devices WHERE id = ? AND user_id = ?",
            [$deviceId, $userId]
        );
    }
}

