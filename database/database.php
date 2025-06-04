<?php

namespace App\Database;
use Exception;
use PDO;




class BD
{
    private static $host = 'localhost';
    private static $dbname = 'revive';
    private static $username = 'root';
    private static $password = '';

    /**
     * Instancia de la conexión PDO.
     * 
     * @var PDO|null
     */
    private static $consexion = null;

    /**
     * Opens the connection to the database if it is not already established.
     *
     * Creates a new PDO instance for the connection to the MySQL database.
     * If the connection fails, prints a JSON message and terminates the execution.
     *
     * @return void
     */
    private static function openConexion()
    {
        if (self::$consexion === null) {
            self::$consexion = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
            if (!self::$consexion) {
                echo '{"estado":"sin conexion"}';
                exit;
            }
        }
    }

    /**
     * Cierra la conexión a la base de datos si está abierta.
     * 
     * Establece la instancia de conexión a null para liberar recursos.
     * 
     * @return void
     */
    public static function closeConsexion()
    {
        if (self::$consexion !== null) {
            self::$consexion = null;
        }
    }

    /**
     * Convierte las claves de un arreglo asociativo en una cadena separada por comas.
     * 
     * @param array $array Arreglo asociativo cuyas claves se convertirán.
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
     * Crea una cadena con signos de interrogación separados por comas, según la cantidad especificada.
     * 
     * Esta cadena se utiliza para consultas preparadas con parámetros.
     * 
     * @param int $number Cantidad de signos de interrogación a crear.
     * @return string Cadena con signos de interrogación separados por comas.
     */
    public static function implodeInterogation(int $number): string
    {
        return implode(",", array_fill(0, $number, "?"));
    }

    /**
     * Crea una cadena con la condición WHERE para una consulta SQL.
     * 
     * Genera una cadena con condiciones del tipo "columna = ?" unidas por " AND ".
     * 
     * @param array $where Arreglo asociativo con columnas y valores para la condición.
     * @return string Cadena con la condición WHERE para la consulta SQL.
     */
    private static function strWhere(array $where): string
    {
        $columns = array_keys($where);
        return implode(" AND ", array_map(function ($column) {
            return "$column = ?";
        }, $columns));
    }

    /**
     * Ejecuta una transacción en la base de datos.
     * 
     * Abre la conexión, inicia la transacción, ejecuta el callback, y confirma o revierte la transacción.
     * Finalmente cierra la conexión.
     * 
     * @param callable $callback Función que contiene las operaciones a ejecutar dentro de la transacción.
     * @return mixed Resultado devuelto por el callback o un arreglo vacío en caso de error.
     */
    public static function starTransaction(callable $callback)
    {
        self::openConexion();
        if (self::$consexion->inTransaction()) {
            try {
                return $callback();
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        } else {
            self::$consexion->beginTransaction();
            try {
                $result = $callback();
                self::$consexion->commit();
                return $result;
            } catch (Exception $e) {
                self::$consexion->rollBack();
                return ["error" => $e->getMessage()];
            } finally {
                self::closeConsexion();
            }
        }
    }

    /**
     * Devuelve los datos solicitados de una tabla de la base de datos.
     * 
     * @param string $table Nombre de la tabla.
     * @param string[]|string $data Columnas a seleccionar o "*" para todas.
     * @param array|null $condition Condiciones para la cláusula WHERE (opcional).
     * @param int|null $max Parámetro no utilizado actualmente (opcional).
     * @param int|null $min Parámetro no utilizado actualmente (opcional).
     * @return array Arreglo asociativo con los resultados de la consulta.
     */
    public static function getData(string $table, $data = "*", ?array $condition = null, ?int $max = null, ?int $min = null): array
    {
        if (is_array($data)) {
            $data = self::implodeValues($data);
        }

        return self::starTransaction(function () use ($table, $data, $condition, $max, $min) {
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
     * Ejecuta una consulta SQL personalizada con parámetros y devuelve los resultados.
     * 
     * @param string $query Consulta SQL a ejecutar.
     * @param array $params Parámetros para la consulta preparada.
     * @return array Arreglo asociativo con los resultados de la consulta.
     */
    public static function getDataWithQuery(string $query, array $params = []): array
    {
        return self::starTransaction(function () use ($query, $params) {
            $prepare = self::$consexion->prepare($query);
            $prepare->execute($params);
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    /**
     * Devuelve la primera fila de los datos solicitados de una tabla.
     * 
     * @param string $table Nombre de la tabla.
     * @param string[]|string $data Columnas a seleccionar o "*" para todas.
     * @param array $condition Condiciones para la cláusula WHERE.
     * @return array|bool La primera fila de resultados o false si no hay resultados.
     */
    public static function getFirstRow(string $table, array|string $data, array $condition): array|bool
    {
        $result = self::getData($table, $data, $condition);
        if (!empty($result)) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Devuelve los datos de una tabla donde el valor de una columna está dentro de un conjunto dado.
     * 
     * @param string $table Nombre de la tabla.
     * @param string $column Columna para la condición IN.
     * @param array $values Valores para la condición IN.
     * @param string[]|string $data Columnas a seleccionar o "*" para todas.
     * @return array Arreglo asociativo con los resultados de la consulta.
     */
    public static function getDataIn(string $table, string $column, array $values, $data = "*"): ?array
    {
        if (is_array($data)) {
            $data = self::implodeValues($data);
        }

        if (empty($values)) {
            return null;
        }

        $placeholders = implode(",", array_map(function ($value) {
            if (is_numeric($value)) {
                return $value;
            } else {
                return "'" . addslashes($value) . "'";
            }
        }, $values));

        $sql = "SELECT $data FROM $table WHERE $column IN ($placeholders)";

        return self::starTransaction(function () use ($sql) {
            $prepare = self::$consexion->prepare($sql);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    /**
     * Actualiza un valor en una columna específica de una tabla.
     * 
     * @param string $table Nombre de la tabla.
     * @param string $column Columna a actualizar.
     * @param string $value Nuevo valor para la columna.
     * @param int $id Identificador del registro a actualizar.
     * @return void
     */
    public static function UpdateTable(string $table, string $column, string $value, int $id): void
    {
        $query = "UPDATE $table SET $column = ? WHERE id = ?";
        $params = [$value, $id];
        self::execute($query, $params);
    }

    /**
     * Actualiza múltiples columnas en una tabla para un registro específico.
     * 
     * @param string $table Nombre de la tabla.
     * @param array $columnValues Arreglo asociativo con columnas y sus nuevos valores.
     * @param int $id Identificador del registro a actualizar.
     * @return bool True si la actualización fue exitosa.
     */
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
        return true;
    }

    /**
     * Ejecuta una consulta SQL con parámetros.
     * 
     * @param string $query Consulta SQL a ejecutar.
     * @param array $params Parámetros para la consulta preparada.
     * @return bool True si la ejecución fue exitosa.
     */
    public static function execute(string $query, array $params = null)
    {
        return self::starTransaction(function () use ($query, $params) {
            $prepare = self::$consexion->prepare($query);
            $result = $prepare->execute($params);
            return $result;
        });
    }

    /**
     * Inserta un nuevo registro en una tabla.
     * 
     * @param string $table Nombre de la tabla.
     * @param array $datos Arreglo asociativo con columnas y valores a insertar.
     * @return bool True si la inserción fue exitosa.
     */
    public static function InsertIntoTable(string $table, array $datos)
    {
        $columns = "( " . self::implodeKeys($datos) . " )";
        $values = "( " . self::implodeInterogation(count($datos)) . " )";
        $query = "INSERT INTO $table $columns VALUES $values";
        $params = array_values($datos);
        $result = self::execute($query, $params);
        return $result;
    }

    /**
     * Verifica si existe un valor en una columna de una tabla.
     * 
     * @param string $column Columna a validar.
     * @param mixed $value Valor a buscar en la columna.
     * @param string $table Nombre de la tabla.
     * @return bool True si el valor existe, false en caso contrario o en caso de error.
     */
    public static function exist(string $column, $value, string $table): bool
    {
        self::openConexion();
        try {
            $prepare = self::$consexion->prepare("SELECT $column FROM $table WHERE $column = ?");
            $prepare->execute([$value]);
            $resultado = $prepare->rowCount() > 0;
            return $resultado;
        } catch (Exception $e) {
            return false;
        } finally {
            self::closeConsexion();
        }
    }

    /**
     * Elimina un registro de una tabla según su clave primaria.
     * 
     * @param string $table Nombre de la tabla.
     * @param string $primaryKey Nombre de la columna clave primaria.
     * @param int $id Valor de la clave primaria del registro a eliminar.
     * @return bool True si la eliminación fue exitosa.
     */
    public static function DeleteFromTable(string $table, string $primaryKey, int|string $id)
    {
        return self::starTransaction(function () use ($table, $primaryKey, $id) {
            $query = "DELETE FROM $table WHERE $primaryKey = ?";
            return self::execute($query, [$id]);
        });
    }

    /**
     * Cuenta el número de filas en una tabla según una condición.
     *
     * @param string $table El nombre de la tabla.
     * @param array $condition Condiciones para la cláusula WHERE.
     * @return int El número de filas que coinciden con la condición.
     */
    public static function countData(string $table, array $condition): int
    {
        return self::starTransaction(function () use ($table, $condition) {
            $where = self::strWhere($condition);
            $valores = array_values($condition);
            $prepare = self::$consexion->prepare("SELECT COUNT(*) FROM $table WHERE $where");
            $prepare->execute($valores);
            return (int) $prepare->fetchColumn();
        });
    }






    /**
     * Verifica si existe un registro en una tabla que coincida con múltiples condiciones.
     *
     * @param string $table Nombre de la tabla.
     * @param array $conditions Arreglo asociativo con las columnas y valores para la condición WHERE.
     * @return bool True si existe un registro que coincida con todas las condiciones, false en caso contrario.
     */
    public static function existMultiple(string $table, array $conditions): bool
    {
        self::openConexion();
        try {
            $whereClauses = [];
            $params = [];
            foreach ($conditions as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = $value;
            }
            $whereClause = implode(" AND ", $whereClauses);
            $query = "SELECT 1 FROM $table WHERE $whereClause";
            $prepare = self::$consexion->prepare($query);
            $prepare->execute($params);
            $resultado = $prepare->rowCount() > 0;
            return $resultado;
        } catch (Exception $e) {
            return false;
        } finally {
            self::closeConsexion();
        }
    }

    /**
     * Obtiene el último ID insertado en la tabla especificada.
     *
     * @param string $table Nombre de la tabla.
     * @return string El último ID insertado.
     */
    public static function getLastInsertIdForTable(string $table): int
    {
        $query = "SELECT id FROM $table ORDER BY id DESC LIMIT 1";
        $result = self::getDataWithQuery($query);

        if (!empty($result)) {
            return (int) $result[0]['id'];
        }

        return 0;
    }
}
