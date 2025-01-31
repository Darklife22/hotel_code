<?php
session_start();
require_once '../../backend/funciones.php'; // Incluye las funciones de verificación de rol

if (!isRecepcionista()) {
    header("Location: ../../index.php");
    exit();
}

// ... (código específico para la vista de recepcionista)
?>

<h1>Panel de recepcionista</h1>

<?php include '../../partials/footer.php'; ?>