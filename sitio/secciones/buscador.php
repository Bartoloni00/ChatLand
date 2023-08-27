<?php
$usuariosAmostrar = isset($_SESSION['buscador']) ? $_SESSION['buscador'] : $usuarios;
unset($_SESSION['buscador']);
?>

<form action="acciones/buscador.php" method="post" class="buscador">
    <label for="buscador">Buscador</label>
    <input type="text" name="buscador" id="buscador">
    <button type="submit" name="accion" value="buscar">Buscar</button>
    <button type="submit" name="accion" value="reiniciar">Reiniciar</button>
</form>
<div class="otros-users">
<?php foreach ($usuariosAmostrar as $usuario):?>
    <?php if ((new Auth)->getUsuarios()->getEmail() !== $usuario->getEmail()):?>
        <div class="usuario">
            <?php
            $foto = (new Fotos)->traerPorUsuario($usuario->getIdUsuarios());
            $nombreFoto = $foto ? $foto->getNombre() : 'default.png';
            ?>
       <img src="./assets/users/<?= $nombreFoto ?>" alt="Foto de perfil del usuario <?= $usuario->getUsername() ?>">
        <?= $usuario->getEmail()?>
            <form action="acciones/crear-chat.php" method="post">
                <input type="hidden" name="id_usuario1" value="<?=$usuario->getIdUsuarios()?>">
                <button type="submit">Crear chat</button>
            </form>
        </div>
    <?php endif;?>
<?php endforeach;?>
</div>