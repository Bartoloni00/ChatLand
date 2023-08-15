<?php
$rutas = [
    'error' => [
     'title' => 'Página no encontrada',
    ],
     'chat' => [
      'title' => 'Chat',
      'requiereAutenticacion' => true
     ],
     'buscador' => [
        'title' => 'Buscador',
        'requiereAutenticacion' => true
       ]
    ];

$vistaInterna = $_GET['ss'] ?? 'buscador';

if(!isset($rutas[$vistaInterna])) {
// Esta vistaInterna no "existe", así que mostramos una pantalla de error.
$vistaInterna = 'error';
}

$rutaOpciones = $rutas[$vistaInterna];


    $usuarios = (new Usuarios)->todo();
    $idUsuarioAutenticado = (new Auth)->getUsuarios()->getIdUsuarios();
    $claseChats = (new Chat);
    $chats = $claseChats->traerChatsDelUsuario($idUsuarioAutenticado);
?>
<section id="chats">
    <article class="menu">
        <nav>
            <ul>
                <li>
                    <a href="index.php?s=profile">perfil</a>
                </li>
                <li>
                    <a href="#">contactos</a>
                </li>
                <li>
                    <a href="acciones/cerrar-session.php">cerrar</a>
                </li>
                <li>
                    <a href="index.php?s=chats&ss=buscador">Buscador</a>
                </li>
            </ul>
        </nav>
    </article>
    <article class="chats">
        <ul>
            <?php foreach ($chats as $chat):?>
                <li class="chat">
                    <a href="http://localhost/chatLand/sitio/index.php?s=chats&ss=chat&id=<?=$chat->getIdChats();?>">
                        <?php 
                            $usuariosDelChat = $claseChats->traerUsuariosDelChat($chat->getIdChats());
                            foreach ($usuariosDelChat as $usuario) {
                                if ($usuario !== $idUsuarioAutenticado) {
                                    echo 'Tu conversacion con '. (new Usuarios)->porId($usuario)->getUsername();
                                }
                            }
                        ?>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    </article>
    <article class="principal-article">
        <?php
        require_once __DIR__ . '/' . $vistaInterna . '.php';
        ?>
    </article>
</section>