<?php
namespace Bartoloni00\Modelos;

use \Bartoloni00\Conexion\DB;
use \PDO;

class Mensaje {
    private int $id_mensajes;
    private string $contenido;
    private string $tiempo_de_envio;
    private int $fk_usuarios;
    private int $fk_chat;

    /**
     * Crea un nuevo mensaje y lo inserta en la base de datos.
     *
     * @param array $data Los datos del mensaje a crear.
     * @return void
     */
    public function crearMensaje(array $data): void {
        $db = DB::getConexion();
        $query = "INSERT INTO mensajes (contenido, tiempo_de_envio, fk_usuarios, fk_chat)
                    VALUES (:contenido, :tiempo_de_envio, :fk_usuarios, :fk_chat)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'contenido'       => $data['contenido'],
            'tiempo_de_envio' => $data['tiempo_de_envio'],
            'fk_usuarios'     => $data['fk_usuarios'],
            'fk_chat'         => $data['fk_chat']
        ]);
    }

    /**
     * Trae los mensajes de un chat específico ordenados por tiempo de envío.
     *
     * @param int $fk_chat Los datos para filtrar los mensajes del chat.
     * @return array Array de objetos Mensaje del chat.
     */
    public function traerMensajesDeUnChat(int $fk_chat): array {
        $db = DB::getConexion();
        $query = "SELECT * FROM mensajes 
                WHERE fk_chat = ?
                ORDER BY tiempo_de_envio ASC;";
        $stmt = $db->prepare($query);
        $stmt->execute([$fk_chat]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetchAll();
    }

    // Getter for $id_mensajes
    public function getIdMensajes(): int {
        return $this->id_mensajes;
    }

    // Setter for $id_mensajes
    public function setIdMensajes(int $id_mensajes): void {
        $this->id_mensajes = $id_mensajes;
    }

    // Getter for $contenido
    public function getContenido(): string {
        return $this->contenido;
    }

    // Setter for $contenido
    public function setContenido(string $contenido): void {
        $this->contenido = $contenido;
    }

    // Getter for $tiempo_de_envio
    public function getTiempoDeEnvio(): string {
        return $this->tiempo_de_envio;
    }

    // Setter for $tiempo_de_envio
    public function setTiempoDeEnvio(string $tiempo_de_envio): void {
        $this->tiempo_de_envio = $tiempo_de_envio;
    }

    // Getter for $fk_usuarios
    public function getFkUsuarios(): int {
        return $this->fk_usuarios;
    }

    // Setter for $fk_usuarios
    public function setFkUsuarios(int $fk_usuarios): void {
        $this->fk_usuarios = $fk_usuarios;
    }

    // Getter for $fk_chat
    public function getFkChat(): int {
        return $this->fk_chat;
    }

    // Setter for $fk_chat
    public function setFkChat(int $fk_chat): void {
        $this->fk_chat = $fk_chat;
    }
        
}
