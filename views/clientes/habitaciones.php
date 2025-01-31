<?php
session_start();
include '../../backend/db.php';
include '../../backend/habitaciones.php';
include '../../partials/navbar.php';

$habitaciones = getRooms($conn);
?>

<div class="container">
    <h1>Habitaciones disponibles</h1>
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

<?php include '../../partials/footer.php'; ?>