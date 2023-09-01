<?php
  namespace Bartoloni00\Modelos;

use \Bartoloni00\Conexion\DB;
use \Bartoloni00\Modelos\Usuarios;
use PDO;

class Buscador extends Usuarios {
    /**
     * Devuelve a los usuarios que su username coincide con los caracteres proporcionados. intenta envolver el string entre 2 %.
     * %username% de esta manera
     * 
     * @param string $username : el username por el que deseas filtrar a los usuarios.
     * @return array retorna un array de objetos Usuarios
     */
    public function buscarPorUsername(string $username) :array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM " . $this->tabla . " WHERE username LIKE ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$username]);

        $stmt->setFetchMode(PDO::FETCH_CLASS,Usuarios::class);// static es Modelo solo si se ejecuta el método en una instancia de Modelo, sino será el nombre de la clase de la instancia.
        return $stmt->fetchAll();
    }

    /**
     * Devuelve a los usuarios que su email coincide con los caracteres proporcionados. intenta envolver el string entre 2 %.
     * %email% de esta manera
     * 
     * @param string $email : el email por el que deseas filtrar a los usuarios.
     * @return array retorna un array de objetos Usuarios
     */
    public function buscarPorEmail(string $email) :array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM " . $this->tabla . " WHERE email LIKE ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);

        $stmt->setFetchMode(PDO::FETCH_CLASS,Usuarios::class);// static es Modelo solo si se ejecuta el método en una instancia de Modelo, sino será el nombre de la clase de la instancia.
        return $stmt->fetchAll();
    }
}