<nav>
    <a href="/hotel_codigo/index.php">Inicio</a>
    <?php if (isset($_SESSION['rol'])): ?>
        <?php if ($_SESSION['rol'] == 'admin'): ?>
            <a href="/hotel_codigo/views/admin.php">Admin</a>
        <?php endif; ?>
        <a href="/hotel_codigo/views/habitaciones.php">Habitaciones</a>
        <a href="/hotel_codigo/views/reservas.php">Reservas</a>
        <a href="/hotel_codigo/views/contacto.php">Contacto</a>
        <a href="/hotel_codigo/partials/logout.php">Cerrar sesión</a>
    <?php else: ?>
        <a href="/hotel_codigo/views/login.php">Iniciar sesión</a>
    <?php endif; ?>
</nav>