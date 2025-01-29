<?php
$host = 'localhost';
$dbname = 'hotel_db';
$username = 'root';
$password = 'admin1234'; // Reemplaza con tu contraseña real

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // --- Mensajes de éxito y detalles ---
    echo "Conexión exitosa a la base de datos.<br>";
    echo "Información del host: " . $conn->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "<br>"; // Detalles del host

    // --- Prueba de consulta (opcional) ---
    $stmt = $conn->query("SELECT VERSION()"); // Consulta sencilla para verificar la conexión
    $version = $stmt->fetchColumn();
    echo "Versión de MySQL: " . $version . "<br>";

    // --- (No incluir en producción) Mostrar errores detallados en desarrollo ---
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

} catch (PDOException $e) {
    // --- Mensajes de error detallados ---
    echo "Error de conexión: " . $e->getMessage() . "<br>";
    echo "Código de error: " . $e->getCode() . "<br>"; // Código de error específico
    echo "Archivo: " . $e->getFile() . "<br>"; // Archivo donde ocurrió el error
    echo "Línea: " . $e->getLine() . "<br>"; // Línea donde ocurrió el error

    // --- (Opcional) Log del error ---
    error_log("Error de conexión: " . $e->getMessage());

    exit; // Detener la ejecución si hay un error de conexión
}
?>