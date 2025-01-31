<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'administrador') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $error_message = "Error al eliminar usuario: " . $e->getMessage();
        error_log($error_message); // Registra el error
        // Puedes mostrar un mensaje de error o redirigir a una página de error
        echo $error_message; // Muestra el mensaje de error
        // O, para redirigir:
        // header("Location: index.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    echo "ID de usuario no especificado.";
    exit();
}
?>