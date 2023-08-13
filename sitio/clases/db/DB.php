<?php
/**
* Conexion a la base de datos
*/
class DB{
    protected static string $host = '127.0.0.1';
    protected static string $usuario = 'root';
    protected static string $contrasenia = '';
    protected static string $nombre = 'chatLand';

    protected static ?PDO $db = null;
    /**
     * Obtiene la conexion de la base de datos
     * 
     */
    public static function getConexion(): PDO{
        //La palabra clave self se utiliza para acceder a elementos estáticos de una clase
        if(self::$db === null){
            $dsn = 'mysql:host='. self::$host.';dbname='.self::$nombre . ';charset=utf8mb4';
        try{
            self::$db = new PDO($dsn, self::$usuario, self::$contrasenia);
        } catch(Exception $error) {
            echo 'Error al conectar con MySQL <br>';
            echo 'El error eso: '. $error->getMessage();
            exit;
        }
        }
        return self::$db;
    }
}