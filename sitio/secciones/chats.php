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
    <article class="chats">
    <nav class="menu">
            <ul>
                <li>
                    <a href="index.php?s=profile">perfil</a>
                </li>
                <li>
                    <a href="index.php?s=chats&ss=buscador">Buscador</a>
                </li>
                <li>
                    <a href="acciones/cerrar-session.php">cerrar</a>
                </li>
            </ul>
        </nav>
        <ul>
            <?php foreach ($chats as $chat):?>
                <li class="chat">
                    <a href="index.php?s=chats&ss=chat&id=<?=$chat->getIdChats();?>">
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