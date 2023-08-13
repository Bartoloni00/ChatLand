<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';

class Chat extends Modelo {
    protected string $tabla = "chats";
    protected string $clavePrimaria = "id_chats";

    private int $id_chats;
    private string $ultima_actividad;
/**
 * Crea un nuevo chat en la base de datos.
 *
 * @return int El ID del chat recién creado.
 */
private function crearChat(): int {
    // Obtenemos una conexión a la base de datos
    $db = DB::getConexion();
    
    // Consulta SQL para insertar un nuevo chat
    $query = "INSERT INTO `chats` (`id_chats`, `ultima_actividad`) VALUES (NULL, :ultima_actividad);";
    
    // Obtenemos la fecha y hora actual de Argentina
    $ultima_actividad = $this->obtenerFecha();
    
    // Preparamos la consulta y la ejecutamos
    $stmt = $db->prepare($query);
    $stmt->execute(['ultima_actividad' => $ultima_actividad]);
    
    // Obtenemos el ID del chat recién creado
    $id_chat = $db->lastInsertId();
    
    return $id_chat;
}

/**
 * Crea una conversación entre dos usuarios.
 *
 * @param int $fk_usuario1 El ID del primer usuario.
 * @param int $fk_usuarioCreador El ID del usuario que crea la conversación.
 * @return void
 */
public function crearConversacion(int $fk_usuario1, int $fk_usuarioCreador): void {
    // Creamos un nuevo chat y obtenemos su ID
    $id_chat = $this->crearChat();
    
    // Asignamos usuarios al chat recién creado
    $this->crearChats_de_usuarios($id_chat, $fk_usuario1);
    $this->crearChats_de_usuarios($id_chat, $fk_usuarioCreador);
}

/**
 * Crea un registro en la tabla `chats_de_usuarios` para vincular un usuario a un chat.
 *
 * @param int $fk_chats El ID del chat.
 * @param int $fk_usuarios El ID del usuario.
 * @return void
 */
private function crearChats_de_usuarios(int $fk_chats, int $fk_usuarios): void {
    // Obtenemos una conexión a la base de datos
    $db = DB::getConexion();
    
    // Consulta SQL para insertar un nuevo registro en `chats_de_usuarios`
    $query = "INSERT INTO `chats_de_usuarios` (`fk_chats`, `fk_usuarios`) VALUES (:fk_chats, :fk_usuarios)";
    
    // Preparamos la consulta y la ejecutamos
    $stmt = $db->prepare($query);
    $stmt->execute([
        'fk_chats' => $fk_chats,
        'fk_usuarios' => $fk_usuarios
    ]);
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


    // Getter para id_chats
    public function getIdChats(): int {
        return $this->id_chats;
    }

    // Setter para id_chats
    public function setIdChats(int $id_chats): void {
        $this->id_chats = $id_chats;
    }

    // Getter para ultima_actividad
    public function getUltimaActividad(): string {
        return $this->ultima_actividad;
    }

    // Setter para ultima_actividad
    public function setUltimaActividad(string $ultima_actividad): void {
        $this->ultima_actividad = $ultima_actividad;
    }
}