<?php
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
                $chatCon .= (new Usuarios)->porId($usuario)->getUsername();
                break;
            }
        }
    }else{
        $_SESSION['mensajeError'] = 'Parece que este chat no existe';
        header('Location: index.php?s=chats');
        exit;
    }
?>
<header class="buscador">
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
    </div>
<?php endforeach;?>

</div>
<footer class="chat-footer">
    <form action="acciones/enviar-mensaje.php" method="post">
        <input type="hidden" name="chat" value="<?=$id?>">
        <label for="mensaje">Mensaje</label>
        <textarea name="mensaje" id="mensaje" cols="30" rows="10"></textarea>
        <button type="submit">Enviar</button>
    </form>
</footer>