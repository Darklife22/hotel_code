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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $id_habitacion = $_POST['id_habitacion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("INSERT INTO reservas (id_cliente, id_habitacion, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_cliente, $id_habitacion, $fecha_inicio, $fecha_fin, $estado]);

    header("Location: index.php");
    exit();
}
?>

<h1>Crear reserva</h1>

<form method="POST">
    <label for="id_cliente">Cliente:</label>
    <select name="id_cliente" id="id_cliente" required>
        <?php foreach ($usuarios as $usuario): ?>
            <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nombre']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="id_habitacion">Habitación:</label>
    <select name="id_habitacion" id="id_habitacion" required>
        <?php foreach ($habitaciones as $habitacion): ?>
            <option value="<?php echo $habitacion['id']; ?>"><?php echo $habitacion['tipo']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="fecha_inicio">Fecha de inicio:</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" required>

    <label for="fecha_fin">Fecha de fin:</label>
    <input type="date" name="fecha_fin" id="fecha_fin" required>

    <label for="estado">Estado:</label>
    <select name="estado" id="estado">
        <option value="pendiente">Pendiente</option>
        <option value="confirmada">Confirmada</option>
        <option value="cancelada">Cancelada</option>
    </select>

    <button type="submit">Guardar</button>
</form>

<?php include '../../../partials/footer.php'; ?>