<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambiar Password</a>

    <form action="/perfil" class="formulario" method="POST">

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                value="<?php echo $usuario->nombre ; ?>"
                placeholder="Tu Nombre"
            >
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                value="<?php echo $usuario->email ; ?>"
                placeholder="Tu Email"
            >
        </div>


        <input type="submit" value="Guardar Cambios">

    </form>
</div>


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>