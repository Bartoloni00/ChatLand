<?php
use Bartoloni00\Auth\Auth;
use Bartoloni00\Modelos\Fotos;

$usuariosAmostrar = isset($_SESSION['buscador']) ? $_SESSION['buscador'] : $usuarios;
unset($_SESSION['buscador']);
?>

<form action="acciones/buscador.php" method="post" class="buscador">
    <label for="buscador">Buscador</label>
    <input type="text" name="buscador" id="buscador">
    <button type="submit" name="accion" value="buscar" title="Buscar">Buscar</button>
    <button type="submit" name="accion" value="reiniciar" title="Reiniciar busqueda">Reiniciar</button>
</form>
<div class="otros-users">
<?php foreach ($usuariosAmostrar as $usuario):?>
    <?php if ((new Auth)->getUsuarios()->getEmail() !== $usuario->getEmail()):?>
        <div class="usuario">
            <?php
            $foto = (new Fotos)->traerPorUsuario($usuario->getIdUsuarios());
            $nombreFoto = $foto ? $foto->getNombre() : 'default.png';
            ?>
       <img src="./assets/users/<?= $nombreFoto ?>" alt="Foto de perfil del usuario <?= $usuario->getUsername() ?>" title="<?=$usuario->getUsername()?>">
        <div>
            <?= $usuario->getUsername()?>
            <form action="acciones/crear-chat.php" method="post">
                <input type="hidden" name="id_usuario1" value="<?=$usuario->getIdUsuarios()?>">
                <button type="submit" class="btn-auth">Crear chat</button>
            </form>
        </div>
        </div>
    <?php endif;?>
<?php endforeach;?>
</div>