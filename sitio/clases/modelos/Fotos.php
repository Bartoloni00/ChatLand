<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';

class Fotos extends Modelo{
    protected string $tabla = "fotos";
    protected string $clavePrimaria = "id_fotos";

    private int $id_fotos;
    private string $nombre;
    private int $fk_usuario;

    public function agregarFoto(string $nombre, int $fk_usuario): void
    {
        $db = DB::getConexion();
        $query = "INSERT INTO fotos (nombre, fk_usuario)
            VALUES (:nombre, :fk_usuarios)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'nombre'     => $nombre,
            'fk_usuario' => $fk_usuario
        ]);
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