<?php



require_once __DIR__ . "/Table.php";
require_once __DIR__ . "/../Models/User.php";

class Users extends Table
{
    /**
     * Verifica si una variable es una instancia de Users.
     *
     * @param mixed $list Variable a verificar.
     * @return bool True si es instancia de Users, false en caso contrario.
     */
    public static function isUsersList($list)
    {
        return $list instanceof Users;
    }

    public function __construct($input = null)
    {
        parent::__construct();
        if (is_array($input)) {
            foreach ($input as $userItem) {
                $user = User::NewUser($userItem);
                $this->add($user);
            }
        } elseif (self::isUsersList($input)) {
            foreach ($input as $user) {
                $this->add($user);
            }
        } elseif ($input instanceof Table) {
            foreach ($input as $user) {
                if (($user instanceof User)) {
                    $this->add($user);
                }

            }
        }
    }

    /**
     * Agrega un nuevo objeto User a la colección.
     *
     * @param User $user Nuevo usuario a agregar.
     */
    public function add($user)
    {
        parent::add($user);
    }

    /**
     * Devuelve una lista de usuarios filtrados según el callback.
     *
     * @param callable(User): bool $callback Función para filtrar usuarios.
     * @return Users Nueva instancia de Users con los usuarios filtrados.
     */
    public function where(callable $callback): Users
    {
        return new Users(parent::where($callback));
    }

    /**
     * Devuelve el primer usuario que cumple la condición o null si no hay ninguno.
     *
     * @param callable(User): bool|null $callback Función para evaluar la condición.
     * @return User|null Primer usuario que cumple la condición o null.
     */
    public function firstOrNull(?callable $callback = null): ?User
    {
        $result = parent::firstOrNull($callback);
        return $result;
    }

    /**
     * Verifica si algún usuario cumple la condición dada.
     *
     * @param callable(User): bool|null $callback Función para evaluar la condición.
     * @return bool True si algún usuario cumple la condición, false en caso contrario.
     */
    public function any(callable $callback = null): bool
    {
        return parent::any($callback);
    }
}
