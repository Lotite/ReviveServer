<?
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/EntidadBase.php";


abstract class ModeloBase implements EntidadBase
{
    protected array $data;
    protected static string $tableName;
    protected static string $primaryKey;

    protected static array $columns;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Getter mágico para acceder a los datos del modelo.
     *
     * @param string $key Clave del dato a obtener.
     * @return mixed Valor del dato o null si no existe.
     */
    public function __get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Setter mágico para asignar valores a los datos del modelo.
     *
     * @param string $key Clave del dato a asignar.
     * @param mixed $value Valor a asignar.
     */
    public function __set(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Obtiene todos los datos del modelo como un array.
     *
     * @return array Array asociativo con los datos del modelo.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Obtiene el nombre de la tabla asociada al modelo.
     *
     * @return string Nombre de la tabla.
     */
    public static function getTableName(): string
    {
        return static::$tableName;
    }

    /**
     * Obtiene el nombre de la clave primaria de la tabla.
     *
     * @return string Nombre de la clave primaria.
     */
    public static function getPrimaryKey(): string
    {
        return static::$primaryKey;
    }

    /**
     * Obtiene las columnas de la tabla.
     *
     * @return array Array con los nombres de las columnas.
     */
    public static function getColumns(): array
    {
        return static::$columns;
    }

    /**
     * Crea una nueva instancia del modelo y la inserta en la base de datos.
     *
     * @param array $data Datos para crear la nueva instancia.
     * @return self|null Nueva instancia creada o null si falla.
     */
    public static function create(array $data): self
    {
        $tableName = static::getTableName();
        $columns = static::getColumns();
        $values = [];
        foreach ($columns as $column) {
            $values[$column] = $data[$column] ?? null;
        }
        BD::InsertIntoTable($tableName, $values);
        $id = BD::getFirstRow($tableName, [static::getPrimaryKey()], $values)[static::getPrimaryKey()];
        if ($id) {
            return static::findById($id);
        }
        return null;
    }

    /**
     * Guarda o actualiza el modelo en la base de datos.
     *
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function save(): bool
    {
        $primaryKey = static::getPrimaryKey();
        if ($this->$primaryKey) {
            return $this->update($this->data);
        } else {
            $instance = static::create($this->data);
            if ($instance) {
                $this->data[$primaryKey] = $instance->$primaryKey;
                return true;
            }
            return false;
        }
    }

    /**
     * Actualiza los datos del modelo en la base de datos.
     *
     * @param array $data Datos a actualizar.
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function update(array $data): bool
    {
        $tableName = static::getTableName();
        $primaryKey = static::getPrimaryKey();
        $id = $this->$primaryKey;
        if (!$id) {
            return false;
        }
        $columns = static::getColumns();
        $setValues = [];
        $params = [];
        foreach ($columns as $column) {
            if (isset($data[$column])) {
                $setValues[] = "$column = ?";
                $params[] = $data[$column];
            }
        }
        return BD::UpdateMultipleTable($tableName, $params, $id);
    }

    /**
     * Elimina el modelo de la base de datos.
     *
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function delete(): bool
    {
        $tableName = static::getTableName();
        $primaryKey = static::getPrimaryKey();
        $id = $this->$primaryKey;
        if (!$id) {
            return false;
        }
        return BD::DeleteFromTable($tableName, $primaryKey, $id);
    }

    /**
     * Busca una instancia del modelo por su ID.
     *
     * @param int $id ID a buscar.
     * @return self|null Instancia encontrada o null si no existe.
     */
    public static function findById(int $id): ?self
    {
        $tableName = static::getTableName();
        $primaryKey = static::getPrimaryKey();
        $result = BD::getFirstRow($tableName, "*", [$primaryKey => $id]);
        if ($result) {
            return new static($result);
        }
        return null;
    }

    /**
     * Obtiene todas las instancias del modelo.
     *
     * @return array Array de instancias del modelo.
     */
    public static function all(): array
    {
        $tableName = static::getTableName();
        $results = BD::getData($tableName);
        $objects = [];
        foreach ($results as $result) {
            $objects[] = new static($result);
        }
        return $objects;
    }
}
