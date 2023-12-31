<?php
  namespace Bartoloni00\Modelos;
  
  use \Bartoloni00\Conexion\DB;
  use \Bartoloni00\Modelos\Modelo;
  use PDO;

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
     * Trae los chats en los que está involucrado un usuario.
     *
     * @param int $usuario_id El ID del usuario.
     * @return array Array de objetos Chat en los que está el usuario.
     */
    public function traerChatsDelUsuario($usuario_id) 
    {
        $db = DB::getConexion();
        $query = "SELECT c.*
        FROM chats c
        INNER JOIN chats_de_usuarios cu ON c.id_chats = cu.fk_chats
        WHERE cu.fk_usuarios = :usuario_id;";
        $stmt = $db->prepare($query);
        $stmt->execute(['usuario_id' => $usuario_id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS,static::class);// static es Modelo solo si se ejecuta el método en una instancia de Modelo, sino será el nombre de la clase de la instancia.
        return $stmt->fetchAll();
    }

    /**
     * Trae los IDs de usuarios involucrados en un chat.
     *
     * @param int $chat_id El ID del chat.
     * @return array Array de IDs de usuarios en el chat.
     */
    public function traerUsuariosDelChat($chat_id):array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM `chats_de_usuarios` WHERE fk_chats = :fk_chats;";
        $stmt = $db->prepare($query);
        $stmt->execute(['fk_chats' => $chat_id]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN, 1);//traigo un array con los datos de la segunda columna (fk_usuarios)
    }

    /**
     * Verifica si un usuario tiene un chat con otro usuario.
     *
     * @param int $id_usuarioCreador El ID del usuario creador del chat.
     * @param int $id_usuario1 El ID del primer usuario.
     * @return bool Verdadero si tienen un chat, falso si no.
     */
    public function usuarioTieneChatCon(int $id_usuarioCreador,int $id_usuario1): bool
    {
        $chats = $this->traerChatsDelUsuario($id_usuarioCreador);
        foreach ($chats as $chat) {
            $usuariosDelChat = $this->traerUsuariosDelChat($chat->getIdChats());
            if ($usuariosDelChat[0] == $id_usuario1){
                return true;
            }else if($usuariosDelChat[1] == $id_usuario1){
                return true;
            }
        }
        return false;
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