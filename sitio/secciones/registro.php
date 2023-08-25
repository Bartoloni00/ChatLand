<section class="login">
    <article>
        <div class="login-titulos">
            <h1>Registro</h1>
            <a href="index.php?s=login">Login</a>
        </div>
        <form action="acciones/registro.php" method="post">
            <fieldset>
                <legend>Datos de registro</legend>
                <div class="input-container">
                    <label for="email">Email</label>
                    <input type="email" require placeholder="Escribe aqui tu email" id="email" name="email">
                </div>
                <div class="input-container">
                    <label for="username">Nombre de usuario</label>
                    <input type="username" require placeholder="Escribe aqui tu username" id="username" name="username">
                </div>
                <div class="input-container">
                    <label for="password">Contraseña</label>
                    <div>
                        <input type="password" require placeholder="Escribe aqui tu contraseña" id="password" name="password">
                        <span id="ojo">Ojo</span>
                    </div>
                </div>
            </fieldset>
            <div>
                <button type="submit">Registrarse</button>
            </div>
        </form>
    </article>
</section>