<?php
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
            </ul>
        </nav>
    </article>
    <article class="chats">
        <ul>
            <?php foreach ($chats as $chat):?>
                <li class="chat">
                    <a href="http://localhost/chatLand/sitio/index.php?s=chat&id=<?=$chat->getIdChats();?>">
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
    <article class="buscar-contactos">
        <form action="" method="get">
            <label for="buscador">Buscador</label>
            <input type="text" name="buscador" >
        </form>
        <?php foreach ($usuarios as $usuario):?>
            <?php if ((new Auth)->getUsuarios()->getEmail() !== $usuario->getEmail()):?>
                <div class="usuario">
                    <?= $usuario->getEmail()?>
                    <form action="acciones/crear-chat.php" method="post">
                        <input type="hidden" name="id_usuario1" value="<?=$usuario->getIdUsuarios()?>">
                        <button type="submit">Crear chat</button>
                    </form>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </article>
</section>