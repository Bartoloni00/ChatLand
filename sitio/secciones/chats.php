<?php
use Bartoloni00\Modelos\Usuarios;
use Bartoloni00\Auth\Auth;
use Bartoloni00\Modelos\Chat;
use Bartoloni00\Modelos\Fotos;

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
                    <a href="index.php?s=profile">Mi perfil</a>
                </li>
                <li>
                    <a href="index.php?s=chats&ss=buscador">Buscador</a>
                </li>
                <li>
                    <a href="acciones/cerrar-session.php">Cerrar</a>
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
                                    $foto = (new Fotos)->traerPorUsuario($usuario);
                                    $nombreFoto = $foto ? $foto->getNombre() : 'default.png';
                                    echo '<img src="assets/users/mobile/Mobile'.$nombreFoto.'" alt="foto de perfil">';
                                    echo '<span>'.(new Usuarios)->porId($usuario)->getUsername(). '</span>';
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