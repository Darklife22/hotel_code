<?php
session_start();
include '../../backend/db.php';
include '../../partials/navbar.php';

// Obtener el historial de reservas del cliente actual
$id_cliente = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM reservas WHERE id_cliente = ?");
$stmt->execute([$id_cliente]);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Mis reservas</h1>

<?php if ($reservas): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Habitación</th>
                <th>Fecha de inicio</th>
                <th>Fecha de fin</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?php echo $reserva['id']; ?></td>
                    <td><?php echo $reserva['id_habitacion']; ?></td>
                    <td><?php echo $reserva['fecha_inicio']; ?></td>
                    <td><?php echo $reserva['fecha_fin']; ?></td>
                    <td><?php echo $reserva['estado']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No tienes reservas.</p>
<?php endif; ?>

<?php include '../../partials/footer.php'; ?>