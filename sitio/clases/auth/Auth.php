<?php
  namespace Bartoloni00\Auth;

  use \Bartoloni00\Modelos\Usuarios;
//traer usuarios
/**
 * Manejador del estado de autenticacion de usuarios
 */
class Auth{
    /**
     * Inicia sesión de un usuario.
     *
     * @param string $email El correo electrónico del usuario.
     * @param string $password La contraseña del usuario.
     * @return bool Retorna true si el inicio de sesión es exitoso, de lo contrario retorna false.
     */
    public function iniciarSesion(string $email, string $password):bool{
        $usuarios = (new Usuarios)->porEmail($email);
        // si el usuarios no existe:
        if(!$usuarios)return false;
        //si la contraseña no coincide:
        if(!password_verify($password,$usuarios->getPassword()))return false;
        //if(!$password == $usuarios->getPassword()) return false;
        $this->marcarComoAutenticado($usuarios);
        return true;
    }

    /**
     * Marca al usuarios como autenticado.
     *
     * @param Usuarios $usuarios El objeto Usuarios que se marcará como autenticado.
     * @return void
     */
    public function marcarComoAutenticado(Usuarios $usuarios):void{
        $_SESSION['id_usuarios'] = $usuarios->getIdUsuarios();
    }

    /**
     * Cierra la sesión del usuarios.
     *
     * @return void No retorna ningun valor.
     */
    public function cerrarSesion():void{
        unset($_SESSION['id_usuarios']);
    }

    /**
     * Verifica si el usuarios está autenticado.
     *
     * @return bool Retorna true si el usuarios está autenticado, de lo contrario retorna false.
     */
    public function estaAutenticado():bool{
        return isset($_SESSION['id_usuarios']);
    }

     /**
     * Obtiene el objeto Usuarios del usuarios autenticado actualmente.
     *
     * @return Usuarios|null Retorna el objeto Usuarios del usuarios autenticado actualmente, o null si no está autenticado.
     */
    public function getUsuarios(): ?Usuarios{
        if(!$this->estaAutenticado())return null;
        return (new Usuarios)->porId($_SESSION['id_usuarios']);
    }
}  