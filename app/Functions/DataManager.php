<?php

use Illuminate\Support\Facades\Crypt;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Illuminate\Support\Arr;


class DataManager
{
    private static $key = '#0f0';

    private static int $sessionTime = 1; //min

    private static int $cookieTime = 14 * 24 * 60; //min
    private static array $cookies = [];

    /**
     * Inicializa la clase extrayendo todas las cookies del Request y comenzando la sesión de PHP.
     *
     * @param Request|null $request Objeto de la solicitud HTTP
     * @return void
     */
    public static function initialize(Request $request = null): void
    {
        if ($request != null) {
            self::$cookies = $request->cookies->all();
        }

        // Iniciar la sesión de PHP si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Encripta datos en un token JWT.
     *
     * @param array $data Datos a incluir en el token
     * @param int $expiration Tiempo de expiración en segundos (por defecto 3600 segundos = 1 hora)
     * @return string Token JWT generado
     */
    public static function encrypt(array $data, int $expiration = 3600): string
    {
        $payload = $data;
        $payload['exp'] = time() + $expiration;
        return JWT::encode($payload, self::$key, 'HS256');
    }

    /**
     * Desencripta un token JWT para obtener los datos originales.
     *
     * @param string $token Token JWT a decodificar
     * @return array|null Retorna los datos decodificados o null si el token es inválido o expirado
     */
    public static function decrypt(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key(self::$key, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Crea una cookie con los parámetros dados y la almacena internamente.
     *
     * @param string $name Nombre de la cookie
     * @param string $value Valor de la cookie
     * @return SymfonyCookie Objeto cookie para agregar a la respuesta
     */
    public static function addCookie(string $name, $value): SymfonyCookie
    {
        $encryptedValue = self::encrypt(['value' => $value], self::$cookieTime * 60);
        $expireAt = time() + (self::$cookieTime * 60);
        $cookie = new SymfonyCookie($name, $encryptedValue, $expireAt);
        self::$cookies[$name] = $cookie->getValue();
        return $cookie;
    }

    /**
     * Lee el valor de una cookie específica desde la variable interna.
     *
     * @param string $name Nombre de la cookie a leer
     * @return string|null Valor de la cookie o null si no existe
     */
    public static function readCookie(string $name): ?string
    {
        $encryptedValue = self::$cookies[$name] ?? null;
        if ($encryptedValue === null) {
            return null;
        }

        $decrypted = self::decrypt($encryptedValue);
        if ($decrypted === null || !isset($decrypted['value'])) {
            return null;
        }
        return $decrypted['value'];
    }

    /**
     * Añade todas las cookies almacenadas internamente a la respuesta HTTP.
     *
     * @param \Illuminate\Http\JsonResponse $response Objeto de la respuesta HTTP
     * @return \Illuminate\Http\JsonResponse Respuesta con las cookies añadidas
     */
    public static function sendAllCookies($response)
    {
        $expireAt = time() + (self::$cookieTime * 60);
        foreach (self::$cookies as $name => $value) {
            $cookie = new SymfonyCookie($name, $value, $expireAt, '/', "http://192.168.1.141");
            $response->headers->setCookie($cookie);
        }
        return $response;
    }

    /**
     * Establece un valor en la sesión de PHP.
     *
     * @param string $key Clave del valor a guardar en la sesión.
     * @param mixed $value Valor a guardar.
     * @return void
     */
    public static function setSessionData(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtiene datos de la sesión de PHP.
     *
     * @param string $key Clave del dato a obtener
     * @return mixed|null Valor del dato o null si no existe
     */
    public static function getSessionData(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Obtiene un dato primero de la sesión de PHP y si no existe, de las cookies.
     *
     * @param string $key Clave del dato a obtener
     * @return mixed|null Valor del dato o null si no existe en la sesión ni en las cookies.
     */
    public static function getData(string $key)
    {
        $value = self::getSessionData($key);
        if ($value === null) {
            $value = self::readCookie($key);
            if ($value !== null) {
                return $value;
            }
        }
        return $value;
    }
}
