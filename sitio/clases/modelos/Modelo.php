<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';

/**
 * Clase base para todos los modelos del sistema.
 * Incluye métodos para hacer algunas consultas comunes.
 */
class Modelo{
    /** @var string El nombre de la tabla asociada al modelo. */
    protected string $tabla = "";
    /** @var string El nombre de la primary key de la tabla asociada al modelo. */
    protected string $clavePrimaria = "";

/**
 * Trae todos los datos de una tabla (dependiendo de su clase).
 *
 * @return array|static[] Un arreglo de objetos de la clase actual.
 */
    public function todo():array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM " . $this->tabla;
        $stmt = $db->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS,static::class);// static es Modelo solo si se ejecuta el método en una instancia de Modelo, sino será el nombre de la clase de la instancia.
        return $stmt->fetchAll();
    }
    
/**
 * Trae un elemento de una tabla dependiendo de su clave primaria (id).
 *
 * @param int $id Clave primaria del elemento que se desea traer.
 * @return static|null Una instancia de la clase actual o null si no se encuentra el elemento.
 */
    public function porId(int $id): ?static {
        $db = DB::getConexion();
        $query = "SELECT * FROM " . $this->tabla . "
        WHERE " . $this->clavePrimaria . " = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
    
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        $instancia = $stmt->fetch();
        if (!$instancia) {
            return null;
        }
        return $instancia;
    }
    
        /**
     * Obtiene la fecha y hora actual de Argentina.
     *
     * @return string La fecha y hora formateada.
     */
    public function obtenerFecha(): string {
        $fechaRecuperada = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
        return $fechaRecuperada->format('Y-m-d H:i:s.u');
    }
}