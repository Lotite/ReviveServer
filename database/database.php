<?php

namespace App\Database;

use App\Class\Devices;
use App\Class\Medias;
use App\Class\Users;
use Exception;
use PDO;




BD::loadData();
class BD
{
    private static $host = 'localhost';
    private static $dbname = 'revive';
    private static $username = 'root';
    private static $password = '';

    private static $consexion = null;

    public static Users $Users;

    public static Devices $Devices;
    public static Medias $Medias;

    public static function loadData(string $table = "all")
    {
        $function = [
            "users" => [self::class, 'loadUsers'],
            "devices" => [self::class, 'loadDevices'],
            "media" => [self::class, 'loadMedias'],
        ];

        if ($table === "all") {
            foreach ($function as $callback) {
                call_user_func($callback);
            }
        } elseif (isset($function[$table])) {
            call_user_func($function[$table]);
        }
    }

    public static function loadUsers()
    {
        self::$Users = new Users(self::getData("users"));
    }

    public static function loadDevices()
    {
        self::$Devices = new Devices(self::getData("devices"));
    }



    public static function loadMedias()
    {
        self::$Medias = new Medias(self::getData("media"));
    }


    /**
     * Abre la conexión a la base de datos.
     * 
     * Verifica si la conexión ya está establecida, si no, la crea utilizando PDO.
     * 
     * @return void
     */
    private static function openConexion()
    {
        if (self::$consexion == null) {
            self::$consexion = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
            if (!self::$consexion) {
                echo '{"estado":"sin conexion"}';
                exit;
            }
        }
    }




    /**
     * Cierra la conexión a la base de datos.
     * 
     * Verifica si la conexión está establecida, si es así, la cierra.
     * 
     * @return void
     */
    public static function closeConsexion()
    {
        if (self::$consexion != null) {
            //unset(self::$consexion);
            self::$consexion = null;
        }
    }

    /**
     * Convierte las claves de un arreglo en una cadena separada por comas.
     * 
     * @param array $array Arreglo con las claves a convertir.
     * @return string Cadena con las claves separadas por comas.
     */
    private static function implodeKeys(array $array): string
    {
        return implode(",", array_keys($array));
    }

    /**
     * Convierte los valores de un arreglo en una cadena separada por comas.
     * 
     * @param array $array Arreglo con los valores a convertir.
     * @return string Cadena con los valores separados por comas.
     */
    private static function implodeValues(array $array): string
    {
        return implode(",", $array);
    }

    /**
     * Crea una cadena con interrogantes separados por comas, según la cantidad especificada.
     * 
     * @param int $number Cantidad de interrogantes a crear.
     * @return string Cadena con los interrogantes separados por comas.
     */
    private static function implodeInterogation(int $number)
    {
        return implode(",", array_fill(0, $number, "?"));
    }

    /**
     * Crea una cadena con la condición WHERE para una consulta SQL.
     * 
     * @param array $where Arreglo con las columnas y valores para la condición.
     * @return string Cadena con la condición WHERE.
     */
    private static function strWhere(array $where)
    {
        $columns = array_keys($where);
        return implode("and", array_map(function ($column) {
            return "$column = ?";
        }, $columns));
    }








    public static function starTransaction(callable $callback)
    {
        self::openConexion();
        self::$consexion->beginTransaction();
        try {
            $result = $callback();
            self::$consexion->commit();
            return $result;
        } catch (Exception $e) {
            self::$consexion->rollBack();
            return null;
        } finally {
            self::closeConsexion();
        }
    }
    /**
     * Devuelve los datos solicitados de la base de datos.
     * @param string $table la tabla a extraer los datos.
     * @param string[]|string $data array o string que contiene los datos a solicitar.
     * @param string[] $condition  array asociativa que contiene las columnas y los valores de la condicion.
     * @return array array asociativo con los resultados de la consulta.
     */

    public static function getData(string $table, $data = "*", ?array $condition = null): array
    {
        if (is_array($data)) {
            $data = self::implodeValues($data);
        }

        return self::starTransaction(function () use ($table, $data, $condition) {
            if (empty($condition)) {
                $prepare = self::$consexion->prepare("SELECT $data FROM $table");
                $prepare->execute();
            } else {
                $where = self::strWhere($condition);
                $valores = array_values($condition);
                $prepare = self::$consexion->prepare("SELECT $data FROM $table WHERE $where");
                $prepare->execute($valores);
            }
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    /**
     * Devuelve la primera fila de los datos solicitados de la base de datos.
     * 
     * @param string $table La tabla a extraer los datos.
     * @param string[]|string $data array o string que contiene los datos a solicitar.
     * @param array $condition Arreglo asociativo que contiene las columnas y los valores de la condición.
     * 
     * @return array|bool La primera fila de los resultados de la consulta, o false si no hay resultados.
     */
    public static function getFirstRow(string $table, array|string $data, array $condition): array|bool
    {
        $result = self::getData($table, $data, $condition);
        if (!empty($result)) {
            return $result[0];
        } else {
            return false; //No se encontraron resultados
        }
    }





    /**
     * Actualiza un valor en una tabla.
     * @param string $column La columna a actualizar.
     * @param mixed $value El nuevo valor.
     * @param string $table La tabla donde se realizará la actualización.
     * @return void
     */




    public static function UpdateTable(string $table, string $column, string $value, int $id)
    {
        $query = "UPDATE $table SET $column = ? WHERE id = ?";
        $params = [$value, $id];
        self::execute($query, $params);
        self::loadData($table);
    }


    public static function UpdateMultipleTable(string $table, array $columnValues, int $id): bool
    {
        $setClauses = [];
        $params = [];
        foreach ($columnValues as $column => $value) {
            $setClauses[] = "$column = ?";
            $params[] = $value;
        }
        $query = "UPDATE $table SET " . implode(", ", $setClauses) . " WHERE id = ?";
        $params[] = $id;
        self::execute($query, $params);
        self::loadData($table);
        return true;
    }

    private static function execute(string $query, array $params): bool
    {
        return true === self::starTransaction(function () use ($query, $params) {
            $prepare = self::$consexion->prepare($query);
            $prepare->execute($params);
            return true;
        });
    }


    /**
     * modifica una columna en una tabla;
     * @param string[] $datos una array asociativa con las columnas y susvalores a añadir
     * @param string $tabla la cual se añadira los valores
     * @return void
     */

    public static function InsertIntoTable(string $table, array $datos): bool
    {

        $columns = "( " . self::implodeKeys($datos) . " )";
        $values = "( " . self::implodeInterogation(count($datos)) . " )";
        $query = "INSERT INTO $table $columns VALUES $values";
        $params = array_values($datos);
        $result = self::execute($query, $params);
        // self::loadData($table);
        return $result;
    }
    /**
     * Esta funcion verifica si hay un valor coincidente en la tabla
     * @param string $column columna a validar
     * @param mixed $value valor a validar
     * @param string $columna a validar
     */
    public static function exist(string $column, $value, string $table)
    {
        self::openConexion();
        try {
            $prepare = self::$consexion->prepare("SELECT $column from $table where $column = ?");
            $prepare->execute([$value]);
            $resultado = $prepare->rowCount() > 0;
            return $resultado;
        } catch (Exception $e) {
            // devolverError("Error en verificar tus datos");
            return true;
        } finally {
            self::closeConsexion();
        }
    }
    public static function DeleteFromTable(string $table, string $primaryKey, int $id): bool
    {
        return self::starTransaction(function () use ($table, $primaryKey, $id) {
            $query = "DELETE FROM $table WHERE $primaryKey = ?";
            return self::execute($query, [$id]);
        });
    }


}
