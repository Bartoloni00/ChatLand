<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';

class Usuarios extends Modelo{
    protected string $tabla = "usuarios";
    protected string $clavePrimaria = "id_usuarios";

    private int $id_usuarios;
    private ?string $username;
    private string $password;
    private string $email;
    private mixed $ultima_conexion;

    /**
     * Trae a un usuario dependiendo de su email.
     *
     * @param string $email Email del usuario que se desea traer.
     * @return Usuarios|null Una instancia de la clase actual o null si no se encuentra el elemento.
     */
    public function porEmail(string $email): ?Usuarios
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);

        $stmt->setFetchMode(PDO::FETCH_CLASS,Usuarios::class);
        $usuario = $stmt->fetch();

        if(!$usuario) return null;
        return $usuario;
    }

    /**
     * Trae a un usuario dependiendo de su username.
     *
     * @param string $username Username del usuario que se desea traer.
     * @return Usuarios|null Una instancia de la clase actual o null si no se encuentra el elemento.
     */
    public function porUsername(string $username): ?Usuarios
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM usuarios WHERE username = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$username]);

        $stmt->setFetchMode(PDO::FETCH_CLASS,Usuarios::class);
        $usuario = $stmt->fetch();

        if(!$usuario) return null;
        return $usuario;
    }

    /**
     * Crea/Agrega un usuario en la tabla usuarios.
     * 
     * @param array $data Todos los datos necesarios para ejecutar el query.
     *      $data debe contener: email, password y hora de la ultima conexion.
     */
    public function crear(array $data): void
    {
        $db = DB::getConexion();
        $query = "INSERT INTO usuarios (email, password ,username , ultima_conexion)
                VALUES (:email, :password , :username , :ultima_conexion)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'email'          => $data['email'],
            'password'       => $data['password'],
            'username'       => $data['username'],
            'ultima_conexion'=> $data['ultima_conexion'],
        ]);
    }

    /**
     * Elimina un usuario en la tabla usuarios.
     * 
     * @param int $id Clave primaria del Usuario a eliminar
     */
    public function eliminar(int $id): void
    {
        $db = DB::getConexion();
        $query = "DELETE FROM usuarios WHERE id_usuarios = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
    }
    /**
     * Edita un usuario de la tabla usuarios
     * 
     * @param int $id Clave primaria del usuario a editar
     * @param array $data el email y username que queremos actualizar
     */
    public function editar(int $id, array $data): void
    {
        $db = DB::getConexion();
        $query = "UPDATE usuarios 
                  SET email = :email,
                      username = :username
                  WHERE id_usuarios = :id_usuarios";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'email' => $data['email'],
            'username' => $data['username'],
            'id_usuarios' => $id
        ]);
    }

    public function getIdUsuarios(): int {
        return $this->id_usuarios;
    }

    public function setIdUsuarios(int $id_usuarios): void {
        $this->id_usuarios = $id_usuarios;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getUltimaConexion(): mixed {
        return $this->ultima_conexion;
    }

    public function setUltimaConexion(mixed $ultima_conexion): void {
        $this->ultima_conexion = $ultima_conexion;
    }
}