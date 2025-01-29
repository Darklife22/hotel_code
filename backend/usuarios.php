/* Código de db.php */
<?php
$host = 'localhost';
$dbname = 'hotel_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

/* Código de index.php */
<?php
include 'partials/navbar.php';
?>
<h1>Bienvenido al Hotel</h1>
<p>Explora nuestras habitaciones y ofertas.</p>
<?php
include 'partials/footer.php';
?>
