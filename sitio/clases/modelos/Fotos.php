<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';

class Fotos extends Modelo{
    protected string $tabla = "fotos";
    protected string $clavePrimaria = "id_fotos";

    private int $id_fotos;
    private string $nombre;
    private int $fk_usuario;

    /**
     * Agrega la imagen a la tabla fotos.
     * @param array $data = 'nombre' de la imagen y 'fk_usuario' id del usuario al que pertenece dicha imagen
     * @return void
     */
    public function agregarFoto(array $data): void
    {
        $db = DB::getConexion();
        $query = "INSERT INTO fotos (nombre, fk_usuario)
            VALUES (:nombre, :fk_usuario)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'nombre'     => $data['nombre'],
            'fk_usuario' => $data['fk_usuario']
        ]);
    }

    /**
     * Elimina la imagen de la tabla fotos.
     * @param int $fk_usuario = id del usuario que queremos eliminar su foto.
     * @return void
     */
    public function eliminarFoto(int $fk_usuario):void
    {
        $db = DB::getConexion();
        $query = "DELETE FROM fotos WHERE fk_usuario = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$fk_usuario]);
    }

    /**
     * Trae la imagen correspontiente a ese usuario
     * @param int $fk_usuario = id del usuario que queremos traer.
     * @return ?Fotos
     */
    public function traerPorUsuario(int $fk_usuario): ?Fotos
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM fotos WHERE fk_usuario = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$fk_usuario]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        $foto = $stmt->fetch();
        if (!$foto) {
            return null;
        }
        return $foto;
    }
    /**
     * Verifica si el usuario ya tiene una foto agregada
     * 
     * @param int $fk_usuario : el id del usuario del cual queremos verificar si posee o no una foto de perfil
     * @return bool
     */
    public function usuarioTieneFoto(int $fk_usuario): bool
    {
        $imagenes = $this->todo();
        foreach ($imagenes as $imagen) {
            if ($imagen->getFkUsuario() == $fk_usuario) {
                return true;
            }
        }
        return false;
    }

     // Métodos Get
     public function getIdFotos(): int
     {
         return $this->id_fotos;
     }
 
     public function getNombre(): string
     {
         return $this->nombre;
     }
 
     public function getFkUsuario(): int
     {
         return $this->fk_usuario;
     }
 
     // Métodos Set
     public function setIdFotos(int $id_fotos): void
     {
         $this->id_fotos = $id_fotos;
     }
 
     public function setNombre(string $nombre): void
     {
         $this->nombre = $nombre;
     }
 
     public function setFkUsuario(int $fk_usuario): void
     {
         $this->fk_usuario = $fk_usuario;
     }
 
  
}