/* Código de reservas.php */
<?php
include '../backend/db.php';
include '../partials/navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $id_habitacion = $_POST['id_habitacion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $query = "INSERT INTO reservas (id_cliente, id_habitacion, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, 'pendiente')";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_cliente, $id_habitacion, $fecha_inicio, $fecha_fin]);
    echo "Reserva realizada con éxito.";
}
?>
<h1>Reservar Habitación</h1>
<form method="POST">
    <label>ID Cliente:</label>
    <input type="text" name="id_cliente" required>
    <label>ID Habitación:</label>
    <input type="text" name="id_habitacion" required>
    <label>Fecha Inicio:</label>
    <input type="date" name="fecha_inicio" required>
    <label>Fecha Fin:</label>
    <input type="date" name="fecha_fin" required>
    <button type="submit">Reservar</button>
</form>
<?php
include '../partials/footer.php';
?>