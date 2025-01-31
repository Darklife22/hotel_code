<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../partials/navbar.php';

// Obtener la lista de usuarios y habitaciones para los select
$stmtUsuarios = $conn->prepare("SELECT id, nombre FROM usuarios");
$stmtUsuarios->execute();
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

$stmtHabitaciones = $conn->prepare("SELECT id, tipo FROM habitaciones");
$stmtHabitaciones->execute();
$habitaciones = $stmtHabitaciones->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM reservas WHERE id = ?");
    $stmt->execute([$id]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        echo "Reserva no encontrada.";
        exit();
    }
} else {
    echo "ID de reserva no especificado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $id_habitacion = $_POST['id_habitacion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("UPDATE reservas SET id_cliente = ?, id_habitacion = ?, fecha_inicio = ?, fecha_fin = ?, estado = ? WHERE id = ?");
    $stmt->execute([$id_cliente, $id_habitacion, $fecha_inicio, $fecha_fin, $estado, $id]);

    header("Location: index.php");
    exit();
}
?>

<h1>Editar reserva</h1>

<form method="POST">
    <label for="id_cliente">Cliente:</label>
    <select name="id_cliente" id="id_cliente" required>
        <?php foreach ($usuarios as $usuario): ?>
            <option value="<?php echo $usuario['id']; ?>" <?php if ($reserva['id_cliente'] == $usuario['id']) echo 'selected'; ?>><?php echo $usuario['nombre']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="id_habitacion">Habitación:</label>
    <select name="id_habitacion" id="id_habitacion" required>
        <?php foreach ($habitaciones as $habitacion): ?>
            <option value="<?php echo $habitacion['id']; ?>" <?php if ($reserva['id_habitacion'] == $habitacion['id']) echo 'selected'; ?>><?php echo $habitacion['tipo']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="fecha_inicio">Fecha de inicio:</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo $reserva['fecha_inicio']; ?>" required>

    <label for="fecha_fin">Fecha de fin:</label>
    <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo $reserva['fecha_fin']; ?>" required>

    <label for="estado">Estado:</label>
    <select name="estado" id="estado">
        <option value="pendiente" <?php if ($reserva['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
        <option value="confirmada" <?php if ($reserva['estado'] == 'confirmada') echo 'selected'; ?>>Confirmada</option>
        <option value="cancelada" <?php if ($reserva['estado'] == 'cancelada') echo 'selected'; ?>>Cancelada</option>
    </select>

    <button type="submit">Guardar cambios</button>
</form>

<?php include '../../../partials/footer.php'; ?>