<?php
use Bartoloni00\Auth\Auth;
use Bartoloni00\Modelos\Fotos;

$usuario = (new Auth)->getUsuarios();
?>
<h1>mi perfil</h1>
<a href="index.php?s=chats" id="flecha" title="ir hacia atras">ir hacia atras</a>
<form action="acciones/editar-perfil.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Datos del usuario</legend>
        <?php
            $foto = (new Fotos)->traerPorUsuario($usuario->getIdUsuarios());
            $nombreFoto = $foto ? $foto->getNombre() : 'default.png';
            ?>
       <img src="./assets/users/<?= $nombreFoto ?>" alt="Foto de perfil del usuario <?= $usuario->getUsername() ?>">
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