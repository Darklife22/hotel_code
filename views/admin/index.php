<?php
session_start();
require_once '../../backend/funciones.php';

if (!isAdmin()) {
    header("Location: ../../index.php");
    exit();
}

include '../../backend/db.php';
include '../../backend/usuarios.php';
include '../../backend/habitaciones.php';
include '../../backend/reservas.php';

$usuarios = getUsers($conn);
$habitaciones = getRooms($conn);
$reservas = getReservations($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de administración</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css"> </head>
<body>

    <?php include '../../partials/navbar.php'; ?>  <div class="container mt-4">  <h1>Panel de administración</h1>

        <div class="mb-4">  <h2>Usuarios</h2>
            <a href="usuarios/crear.php" class="btn btn-primary">Crear usuario</a>
            <?php displayUsers($usuarios); ?>
        </div>

        <div class="mb-4">  <h2>Habitaciones</h2>
            <a href="habitaciones/crear.php" class="btn btn-primary">Crear habitación</a>
            <?php displayRooms($habitaciones); ?>
        </div>

        <div class="mb-4">  <h2>Reservas</h2>
            <a href="reservas/crear.php" class="btn btn-primary">Crear reserva</a>
            <?php displayReservations($reservas); ?>
        </div>

    </div>

    <?php include '../../partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>