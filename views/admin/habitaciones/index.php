<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../backend/habitaciones.php';
include '../../../partials/navbar.php';

$habitaciones = getRooms($conn);
?>

<h1>Gestión de habitaciones</h1>

<a href="crear.php">Crear habitación</a>

<?php displayRooms($habitaciones); ?>

<?php include '../../../partials/footer.php'; ?>