<?php
include '../backend/db.php';
include '../partials/navbar.php';

// Realizar la consulta a la base de datos
$query = "SELECT * FROM habitaciones";
$stmt = $conn->prepare($query);

try {
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener todos los resultados
    $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Verificar si hay habitaciones disponibles
    if (!$habitaciones) {
        echo "<p>No hay habitaciones disponibles.</p>";
    }
} catch (PDOException $e) {
    echo "Error de consulta: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones Disponibles</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Habitaciones Disponibles</h1>
        <div class="row">
            <?php 
            if (!empty($habitaciones)) {
                foreach ($habitaciones as $habitacion): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($habitacion['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($habitacion['tipo']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($habitacion['tipo']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($habitacion['descripcion']); ?></p>
                                <p class="card-text">Precio: $<?php echo htmlspecialchars($habitacion['precio']); ?></p>
                                <?php if ($habitacion['reservado']): ?>
                                    <p class="text-danger">Reservada</p>
                                <?php else: ?>
                                    <a href="reservas.php?id_habitacion=<?php echo $habitacion['id']; ?>" class="btn btn-primary">Reservar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; 
            } else {
                echo "<p>No hay habitaciones disponibles en este momento.</p>";
            }
            ?>
        </div>
    </div>
<?php
include '../partials/footer.php';
?>
</body>
</html>