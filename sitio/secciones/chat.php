<?php
use Bartoloni00\Auth\Auth;
use Bartoloni00\Modelos\Chat;
use Bartoloni00\Modelos\Usuarios;
use Bartoloni00\Modelos\Fotos;
use Bartoloni00\Modelos\Mensaje;


    $idUsuarioAutenticado = (new Auth)->getUsuarios()->getIdUsuarios();
    $id = $_GET['id']??null;
    if ($id == null) {
        $_SESSION['mensajeError'] = 'Parece que este chat no existe';
        header('Location: index.php?s=chats');
        exit;
    }
    $usuariosDelChat = (new Chat)->traerUsuariosDelChat($id);
    
    if(!empty($usuariosDelChat)){
        $chatCon = 'Este es tu chat con ';
        foreach ($usuariosDelChat as $usuario) {
            if ($usuario !== $idUsuarioAutenticado) {
                $chatConUsuario = (new Usuarios)->porId($usuario);
                $chatCon .= $chatConUsuario->getUsername();
                break;
            }
        }
    }else{
        $_SESSION['mensajeError'] = 'Parece que este chat no existe';
        header('Location: index.php?s=chats');
        exit;
    }
?>
<section class="container">
    <header class="chat-header menu">
        <?php
            $foto = (new Fotos)->traerPorUsuario($chatConUsuario->getIdUsuarios());
            $nombreFoto = $foto ? $foto->getNombre() : 'default.png';
        ?>
        <img src="assets/users/mobile/Mobile<?=$nombreFoto?>" alt="foto de perfil">
        <span>
            <?=$chatCon?>
        </span>
    </header>

    <div class="mensajes">
    <?php
        $mensajes = (new Mensaje)->traerMensajesDeUnChat($id);
    ?>
    <?php foreach ($mensajes as $mensaje):?>
        <div class="mensaje <?= $mensaje->getFkUsuarios() === $idUsuarioAutenticado? 'mensajePropio': 'mensajeDeOtro';?>">
            <p><?=$mensaje->getContenido();?></p>
            <?php 
                $fecha = $mensaje->getTiempoDeEnvio();
            ?>
            <span class="fechaDeEnvio"><?=date("H:i", strtotime($fecha))?></span><!--extraigo la hora y el minuto de la fecha de envio-->
        </div>
    <?php endforeach;?>

    </div>
    <footer class="chat-footer">
        <form action="acciones/enviar-mensaje.php" method="post">
            <input type="hidden" name="chat" value="<?=$id?>">
           <div>
           <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" id="mensaje" cols="30" rows="10"></textarea>
           </div>
            <button type="submit" id="enviar" title="Enviar mensaje">Enviar</button>
        </form>
    </footer>
</section>