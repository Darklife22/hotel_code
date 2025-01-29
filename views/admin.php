<?php
include '../backend/db.php';
include '../partials/navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;
    $oferta = isset($_POST['oferta']) ? 1 : 0;
    $descuento = $_POST['descuento'] ?? 0.00;

    $query = "INSERT INTO habitaciones (tipo, descripcion, precio, disponible, oferta, descuento) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$tipo, $descripcion, $precio, $disponible, $oferta, $descuento]);
    echo "Habitación agregada con éxito.";
}
?>

<h1>Panel de Administración</h1>
<h2>Agregar Nueva Habitación</h2>
<form method="POST">
    <label>Tipo de Habitación:</label>
    <input type="text" name="tipo" required>
    <label>Descripción:</label>
    <textarea name="descripcion" required></textarea>
    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" required>
    <label>Disponible:</label>
    <input type="checkbox" name="disponible">
    <label>Oferta:</label>
    <input type="checkbox" name="oferta">
    <label>Descuento (%)</label>
    <input type="number" name="descuento" step="0.01" min="0" max="100">
    <button type="submit">Guardar</button>
</form>

<?php
include '../partials/footer.php';
?>
