<section class="auth-contenedor">
    <article>
        <div class="auth-titulo">
            <a href="index.php?s=login">Login</a>
            <a href="#">Registro</a>
        </div>
        <form action="acciones/registro.php" method="post" class="form-auth">
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
                <button type="submit" class="btn-auth">Registrarse</button>
                <p>¿Ya tienes cuenta? ¡<a href="index.php?s=login">Logueate</a>!</p>
            </div>
        </form>
    </article>
</section>