<?php
$usuario = (new Auth)->getUsuarios();
?>
<h1>mi perfil</h1>
<a href="index.php?s=chats"><--</a>
<form action="acciones/editar-perfil.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Datos del usuario</legend>
        <img src="./assets/users/default.png" alt="error">
        <div>
            <label for="userImg">Foto de perfil</label>
            <input type="file" name="userImg" id="userImg" accept="image/*">
        </div>
        <div>
            <label for="username">Nombre de usuario</label>
            <input type="text" name="username" id="username" placeholder="<?=$usuario->getUsername()?>" value="<?=$usuario->getUsername()?>">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="<?=$usuario->getEmail()?>" value="<?=$usuario->getEmail()?>">
        </div>
    </fieldset>
    <button type="submit">Confirmar cambios</button>
</form>