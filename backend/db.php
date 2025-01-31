<?php
// db.php
require_once __DIR__ . '/../config.php'; // Ruta absoluta usando __DIR__

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Si la conexión es exitosa, puedes dejar este mensaje para confirmarlo
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    // Este error se mostrará en el navegador
    echo "Error de conexión: " . $e->getMessage();
    // Este error se registrará en el archivo de logs del servidor
    error_log("Error de conexión a la base de datos: " . $e->getMessage());
    die(); // Detiene la ejecución del script para evitar mostrar información sensible
}
?>