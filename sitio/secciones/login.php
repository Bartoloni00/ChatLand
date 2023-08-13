<section class="login">
    <article>
        <div class="login-titulos">
            <h1>Login</h1>
            <a href="index.php?s=registro">Registro</a>
        </div>
        <form action="acciones/login.php" method="post">
            <fieldset>
                <legend>Datos de registro</legend>
                <div class="input-container">
                    <label for="email">Email</label>
                    <input type="email" require placeholder="Escribe aqui tu email" id="email" name="email">
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
                <button type="submit" class="btn-contacto">Ingresar</button>
                <p>¿No tienes cuenta? ¡<a href="index.php?s=registro">Registrate</a>!</p>
            </div>
        </form>
    </article>
</section>