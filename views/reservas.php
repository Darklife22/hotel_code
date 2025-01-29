<?php
include '../backend/db.php';
include '../partials/navbar.php';

$id_habitacion = $_GET['id_habitacion'] ?? null;

if ($id_habitacion) {
    // Obtener información de la habitación
    $query = "SELECT * FROM habitaciones WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_habitacion]);
    $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$habitacion || $habitacion['reservado']) {
        echo "<p>La habitación no está disponible para reservar.</p>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Realizar la reserva
    $query = "INSERT INTO reservas (id_cliente, id_habitacion, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, 'pendiente')";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_cliente, $id_habitacion, $fecha_inicio, $fecha_fin]);

    // Marcar la habitación como reservada
    $updateQuery = "UPDATE habitaciones SET reservado = 1 WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute([$id_habitacion]);

    echo "Reserva realizada con éxito.";
}
?>

<div class="container">
    <h1>Reservar Habitación</h1>
    <?php if ($habitacion): ?>
        <h2><?php echo htmlspecialchars($habitacion['tipo']); ?></h2>
        <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
        <p>Precio: $<?php echo htmlspecialchars($habitacion['precio']); ?></p>
        <form method="POST">
            <label>ID Cliente:</label>
            <input type="text" name="id_cliente" required>
            <label>Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" required>
            <label>Fecha Fin:</label>
            <input type="date" name="fecha_fin" required>
            <button type="submit">Reservar</button>
        </form>
    <?php else: ?>
        <p>No se encontró la habitación.</p>
    <?php endif; ?>
</div>

<?php include '../partials/footer.php'; ?>