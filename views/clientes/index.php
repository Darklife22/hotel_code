<?php
session_start();
require_once '../../backend/funciones.php'; // Incluye las funciones de verificación de rol

if (!isCliente()) {
    header("Location: ../../index.php");
    exit();
}

// ... (código específico para la vista de cliente)
?>

<h1>Panel de cliente</h1>

<?php include '../../partials/footer.php'; ?>