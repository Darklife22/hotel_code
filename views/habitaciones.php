<?php
include '../backend/db.php';
include '../partials/navbar.php';

// Obtener todas las habitaciones
$query = "SELECT * FROM habitaciones";
$stmt = $conn->prepare($query);
$stmt->execute();
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Habitaciones Disponibles</h1>
    <div class="row">
        <?php foreach ($habitaciones as $habitacion): ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($habitacion['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($habitacion['tipo']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($habitacion['tipo']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
                        <p class="card-text">Precio: $<?php echo htmlspecialchars($habitacion['precio']); ?></p>
                        <a href="reservas.php?id_habitacion=<?php echo $habitacion['id']; ?>" class="btn btn-primary">Reservar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../partials/footer.php'; ?>