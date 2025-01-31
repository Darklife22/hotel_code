<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../backend/usuarios.php';
include '../../../partials/navbar.php';

$usuarios = getUsers($conn);
?>

<h1>Gestión de usuarios</h1>

<a href="crear.php">Crear usuario</a>

<?php displayUsers($usuarios); ?>

<?php include '../../../partials/footer.php'; ?>