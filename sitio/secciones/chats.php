<?php
    $usuarios = (new Usuarios)->todo();
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
    </article>
    <article class="buscar-contactos">
        <form action="" method="get">
            <label for="buscador">Buscador</label>
            <input type="text" name="buscador" >
        </form>
        <?php foreach ($usuarios as $usuario):?>
            <?php if ((new Auth)->getUsuarios()->getEmail() !== $usuario->getEmail()):?>
                <div>
                    <?= $usuario->getEmail()?>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </article>
</section>