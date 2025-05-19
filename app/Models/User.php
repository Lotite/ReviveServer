<?php

namespace App\Models;

use App\Database\BD;
use DateTime;




class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public DateTime $created_at;


    public function __construct(?int $idUser = null, ?string $name = null, ?string $email = null, string $password, ?DateTime $created_at = null)
    {
        $this->id = $idUser;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
    }

    /**
     * Crea una nueva instancia de User a partir de un array de datos.
     *
     * @param array $data Datos del usuario.
     * @return User Nueva instancia de User.
     */
    public static function NewUser(array $data)
    {
        $createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $data["created_at"]);
        return new User($data['id'], $data['name'], $data['email'], $data["password"], $createdAt);
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     * Convierte el email a minúsculas y hashea la contraseña.
     *
     * @param array $data Datos para crear el usuario.
     * @return void
     */
    public static function createNewUser(array $data)
    {
        $data["email"] = strtolower($data["email"]);
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        BD::InsertIntoTable("users", $data);
    }

    /**
     * Verifica si existe un usuario con un ID dado.
     *
     * @param mixed $idUser ID a verificar.
     * @return bool True si existe, false en caso contrario.
     */
    public static function ExistsUserId($idUser)
    {
        return is_int($idUser) && BD::exist("id", $idUser, "users");
    }

    /**
     * Obtiene un usuario por su correo electrónico.
     *
     * @param string $email Correo electrónico a buscar.
     * @return User|null Instancia de User o null si no se encuentra.
     */
    public static function getByEmail(string $email): ?User
    {
        return self::NewUser(BD::getFirstRow("users", "*", ["email" => $email]));

    }


    /**
     * Intenta autenticar un usuario con email y contraseña.
     *
     * @param string $email Correo electrónico.
     * @param string $password Contraseña en texto plano.
     * @return User|null Instancia de User si autenticación es exitosa, null en caso contrario.
     */
    public static function loginUser(string $email, string $password): ?User
    {
        $user = self::getByEmail($email);
        if ($user === null) {
            return null;
        }
        if (password_verify($password, $user->password)) {
            return $user;
        } else {
            return null;
        }
    }

    /**
     * Añade un dispositivo asociado al usuario.
     *
     * @param string $deviceName Nombre del dispositivo.
     * @param bool $remember Indica si se debe recordar el dispositivo.
     * @return void
     */
    public function addDevice(string $deviceName, bool $remember = false)
    {
        $device = new Device(
            user_id: $this->id,
            device_name: $deviceName,
        );
        $isCreated = Device::createNewDevice($device);
        if ($isCreated && $remember) {
            $device->rememberDevice();
        }
    }

    /**
     * Obtiene el ID del usuario.
     *
     * @return int ID del usuario.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el ID del usuario.
     *
     * @param int $id Nuevo ID.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Obtiene el nombre del usuario.
     *
     * @return string Nombre del usuario.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Establece el nombre del usuario y actualiza la base de datos.
     *
     * @param string $name Nuevo nombre.
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        $this->Update("name", $name);
    }

    /**
     * Obtiene el correo electrónico del usuario.
     *
     * @return string Correo electrónico.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Establece el correo electrónico del usuario y actualiza la base de datos.
     *
     * @param string $email Nuevo correo electrónico.
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
        $this->Update("email", $email);
    }

    /**
     * Obtiene la contraseña hasheada del usuario.
     *
     * @return string Contraseña hasheada.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Establece la contraseña hasheada y actualiza la base de datos.
     *
     * @param string $password Contraseña en texto plano.
     * @return void
     */
    public function setPassword(string $password): void
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
        $this->Update("password", $hashedPassword);
    }

    /**
     * Obtiene la fecha de creación del usuario.
     *
     * @return DateTime Fecha de creación.
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * Actualiza un campo específico del usuario en la base de datos.
     *
     * @param string $column Nombre de la columna.
     * @param mixed $value Nuevo valor.
     * @return void
     */
    public function Update(string $column, mixed $value)
    {
        if ($this->id !== null) {
            BD::UpdateTable("users", $column, $value, $this->id);
        }
    }
}
