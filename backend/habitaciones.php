/* Código de habitaciones.php */
<?php
include '../backend/db.php';
include '../partials/navbar.php';

$query = "SELECT * FROM habitaciones WHERE disponible = 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Habitaciones Disponibles</h1>
<ul>
    <?php foreach ($habitaciones as $habitacion): ?>
        <li>
            <h2><?php echo htmlspecialchars($habitacion['tipo']); ?></h2>
            <p><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
            <p>Precio: $<?php echo htmlspecialchars($habitacion['precio']); ?></p>
        </li>
    <?php endforeach; ?>
</ul>
<?php
include '../partials/footer.php';
?>