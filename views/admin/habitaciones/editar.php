<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../partials/navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM habitaciones WHERE id = ?");
    $stmt->execute([$id]);
    $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$habitacion) {
        echo "Habitación no encontrada.";
        exit();
    }
} else {
    echo "ID de habitación no especificado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;
    $oferta = isset($_POST['oferta']) ? 1 : 0;
    $descuento = $_POST['descuento'] ?? 0;

    $stmt = $conn->prepare("UPDATE habitaciones SET tipo = ?, descripcion = ?, precio = ?, disponible = ?, oferta = ?, descuento = ? WHERE id = ?");
    $stmt->execute([$tipo, $descripcion, $precio, $disponible, $oferta, $descuento, $id]);

    header("Location: index.php");
    exit();
}
?>

<h1>Editar habitación</h1>

<form method="POST">
    <label for="tipo">Tipo:</label>
    <input type="text" name="tipo" id="tipo" value="<?php echo $habitacion['tipo']; ?>" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" required><?php echo $habitacion['descripcion']; ?></textarea>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" id="precio" value="<?php echo $habitacion['precio']; ?>" required>

    <label for="disponible">Disponible:</label>
    <input type="checkbox" name="disponible" id="disponible" <?php if ($habitacion['disponible']) echo 'checked'; ?>>

    <label for="oferta">Oferta:</label>
    <input type="checkbox" name="oferta" id="oferta" <?php if ($habitacion['oferta']) echo 'checked'; ?>>

    <label for="descuento">Descuento:</label>
    <input type="number" name="descuento" id="descuento" value="<?php echo $habitacion['descuento']; ?>">

    <button type="submit">Guardar cambios</button>
</form>

<?php include '../../../partials/footer.php'; ?>