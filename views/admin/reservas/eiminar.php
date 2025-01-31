<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM reservas WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit();
} else {
    echo "ID de reserva no especificado.";
    exit();
}
?>