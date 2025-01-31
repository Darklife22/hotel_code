<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../partials/navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;
    $oferta = isset($_POST['oferta']) ? 1 : 0;
    $descuento = $_POST['descuento'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO habitaciones (tipo, descripcion, precio, disponible, oferta, descuento) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$tipo, $descripcion, $precio, $disponible, $oferta, $descuento]);

    header("Location: index.php");
    exit();
}
?>

<h1>Crear habitación</h1>

<form method="POST">
    <label for="tipo">Tipo:</label>
    <input type="text" name="tipo" id="tipo" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" required></textarea>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" id="precio" required>

    <label for="disponible">Disponible:</label>
    <input type="checkbox" name="disponible" id="disponible">

    <label for="oferta">Oferta:</label>
    <input type="checkbox" name="oferta" id="oferta">

    <label for="descuento">Descuento:</label>
    <input type="number" name="descuento" id="descuento">

    <button type="submit">Guardar</button>
</form>

<?php include '../../../partials/footer.php'; ?>