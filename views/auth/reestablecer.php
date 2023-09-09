<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Cambiar password</p>

    <?php 
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <?php if($token_valido) { ?>

    <form class="formulario" method="POST">
        <div class="formulario__campo">
            <label for="password" class="formulario__label">Nuevo password</label>
            <input 
                type="password"
                class="formulario__input"
                placeholder="Tu nuevo password"
                id="password"
                name="password"
                >
        </div>

        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repetir password</label>
            <input 
                type="password"
                class="formulario__input"
                placeholder="Repetir nuevo password"
                id="password2"
                name="password2"
                >
        </div>

        <input type="submit" class="formulario__submit" value="Guardar password">
    </form>

    <?php } ?>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tenés una cuenta? Iniciar sesión</a>
        <a href="/registro" class="acciones__enlace">¿No tenés una cuenta? Obtener una</a>
    </div>
</main>