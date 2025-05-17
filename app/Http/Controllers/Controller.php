<?php

namespace App\Http\Controllers;
require_once __DIR__ . "/../../Functions/DataManager.php";
use DataManager;
use Request;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request as HttpRequest;




class Controller
{
    /**
     * Ejecuta un callback dentro de un bloque try-catch para manejar excepciones.
     * Si ocurre una excepcion enviara una respuesta con el error.
     *
     * @param HttpRequest $request Objeto de la solicitud HTTP.
     * @param callable $callback Función a ejecutar.
     * @return \Illuminate\Http\JsonResponse Resultado del callback o mensaje de error.
     */
    public static function ControlerException(HttpRequest $request, callable $callback)
    {
        try {
            DataManager::initialize($request);
            return $callback();
        } catch (\Exception $e) {
            return self::responseMessage(false, "Hubo un error en el servidor: $e", status: 500);
        }
    }

    /**
     * Obtiene el nombre del dispositivo a partir del User-Agent de la solicitud.
     * Utiliza la librería Jenssegers\Agent para identificar plataforma y dispositivo.
     * Si no se puede identificar, devuelve "Desconocido".
     *
     * @param HttpRequest $request Objeto de la solicitud HTTP.
     * @return string Nombre del dispositivo en formato "Plataforma - Dispositivo".
     */
    public static function getNameDevice(HttpRequest $request)
    {
        $userAgent = $request->userAgent();
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        $platform = $agent->platform();
        $device = $agent->device();

        if ($platform == null || $platform == 'unknown') {
            $platform = 'Desconocido';
        }
        if ($device == null || $device == 'unknown') {
            $device = 'Desconocido';
        }
        $deviceName = $platform . ' - ' . $device;
        return $deviceName;
    }

    /**
     * Genera una respuesta JSON estándar con éxito, mensaje, datos y código de estado.
     * Añade las cookies almacenadas en DataManager a la respuesta.
     *
     * @param bool $success Indica si la operación fue exitosa.
     * @param string $message Mensaje descriptivo.
     * @param array $data Datos adicionales para incluir en la respuesta.
     * @param int $status Código HTTP de la respuesta.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con los datos proporcionados.
     */
    public static function responseMessage(bool $success = true, string $message = "", $data = [], int $status = 200)
    {
        $response = response()->json([
            "success" => $success,
            "message" => $message,
            "data" => $data
        ], $status);

        DataManager::sendAllCookies($response);

        return $response;
    }
}
