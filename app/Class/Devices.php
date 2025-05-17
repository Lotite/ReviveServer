<?php

require_once __DIR__ . "/Table.php";
require_once __DIR__ . "/../Models/Device.php";

/**
 * Clase Devices que representa una colección de objetos Device.
 * Extiende la clase Table para manejar una lista de dispositivos.
 */
class Devices extends Table
{
    /**
     * Verifica si una variable es una instancia de Devices.
     *
     * @param mixed $list Variable a verificar.
     * @return bool True si es instancia de Devices, false en caso contrario.
     */
    public static function isDevicesList($list)
    {
        return $list instanceof Devices;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $deviceItem) {
                $device = Device::NewDevice($deviceItem);
                $this->add($device);
            }
        } elseif (self::isDevicesList($input)) {
            foreach ($input as $device) {
                $this->add($device);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $device) {
                if (($device instanceof Device)) {
                    $this->add($device);
                }
            }
        }
    }

    /**
     * Agrega un nuevo objeto Device a la colección.
     * Lanza una excepción si el objeto no es de tipo Device.
     *
     * @param Device $newItem Nuevo dispositivo a agregar.
     * @throws InvalidArgumentException Si $newItem no es instancia de Device.
     */
    public function add($newItem)
    {
        if (!$newItem instanceof Device) {
            throw new InvalidArgumentException("Expected instance of Device.");
        }
        parent::add($newItem);
    }

    /**
     * Devuelve una lista de dispositivos filtrados según el callback.
     *
     * @param callable(Device): bool $callback Función para filtrar dispositivos.
     * @return Devices Nueva instancia de Devices con los dispositivos filtrados.
     */
    public function where(callable $callback): Devices
    {
        return new Devices(parent::where($callback));
    }

    /**
     * Devuelve el primer dispositivo que cumple la condición o null si no hay ninguno.
     *
     * @param callable(Device): bool|null $callback Función para evaluar la condición.
     * @return Device|null Primer dispositivo que cumple la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?Device
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún dispositivo cumple la condición dada.
     *
     * @param callable(Device): bool|null $callback Función para evaluar la condición.
     * @return bool True si algún dispositivo cumple la condición, false en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }
}
