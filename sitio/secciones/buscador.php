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