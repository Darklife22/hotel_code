<?php
session_start();
include '../backend/db.php';
include '../partials/navbar.php';

$id_habitacion = $_GET['id_habitacion'] ?? null;

if ($id_habitacion) {
    $stmt = $conn->prepare("SELECT * FROM habitaciones WHERE id = ?");
    $stmt->execute([$id_habitacion]);
    $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$habitacion) {
        echo "<p>Habitación no encontrada.</p>";
        exit();
    }
} else {
    echo "<p>ID de habitación no especificado.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $stmt = $conn->prepare("INSERT INTO reservas (id_cliente, id_habitacion, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, 'pendiente')");
    $stmt->execute([$id_cliente, $id_habitacion, $fecha_inicio, $fecha_fin]);

    echo "Reserva realizada con éxito.";
}
?>

<div class="container">
    <h1>Reservar habitación</h1>

    <?php if ($habitacion): ?>
        <h2><?php echo htmlspecialchars($habitacion['tipo']); ?></h2>
        <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
        <p>Precio: $<?php echo htmlspecialchars($habitacion['precio']); ?></p>

        <form method="POST">
            <label for="id_cliente">ID Cliente:</label>
            <input type="text" name="id_cliente" id="id_cliente" required>

            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" required>

            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin" required>

            <button type="submit">Reservar</button>
        </form>
    <?php endif; ?>
</div>

<?php include '../partials/footer.php'; ?>