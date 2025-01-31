<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../backend/reservas.php';
include '../../../partials/navbar.php';

$reservas = getReservations($conn);
?>

<h1>Gestión de reservas</h1>

<?php displayReservations($reservas); ?>

<?php include '../../../partials/footer.php'; ?>