<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php"); // Redirigir si no es administrador
    exit();
}

include '../backend/db.php';
include '../backend/habitaciones.php';
include '../backend/reservas.php';
include '../backend/usuarios.php';
include '../partials/navbar.php';

// Procesar formulario de agregar habitación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_habitacion'])) {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;
    $oferta = isset($_POST['oferta']) ? 1 : 0;
    $descuento = $_POST['descuento'] ?? 0.00;

    $query = "INSERT INTO habitaciones (tipo, descripcion, precio, disponible, oferta, descuento) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$tipo, $descripcion, $precio, $disponible, $oferta, $descuento]);
    echo "Habitación agregada con éxito.";
}

// Obtener todas las habitaciones, reservas y usuarios
$habitaciones = obtenerHabitaciones($conn);
$reservas = obtenerReservas($conn);
$usuarios = obtenerUsuarios($conn);
?>

<h1>Panel de Administración</h1>

<h2>Habitaciones</h2>
<a href="agregar_habitacion.php" class="btn btn-primary">Agregar Habitación</a>
<?php mostrarHabitaciones($habitaciones); ?>

<h2>Reservas</h2>
<?php mostrarReservas($reservas); ?>

<h2>Usuarios</h2>
<?php mostrarUsuarios($usuarios); ?>

<?php include '../partials/footer.php'; ?>