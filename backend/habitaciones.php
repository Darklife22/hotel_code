<?php
include '../backend/db.php';

// Obtener todas las habitaciones
$query = "SELECT * FROM habitaciones";
$stmt = $conn->prepare($query);
$stmt->execute();
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para mostrar las habitaciones en una tabla (se usará en admin.php)

function obtenerHabitaciones($conn) {
    $query = "SELECT * FROM habitaciones";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function mostrarHabitaciones($habitaciones) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>Tipo</th><th>Descripción</th><th>Precio</th><th>Disponible</th><th>Oferta</th><th>Descuento</th><th>Acciones</th></tr></thead>";
    echo "<tbody>";
    foreach ($habitaciones as $habitacion) {
        echo "<tr>";
        echo "<td>" . $habitacion['id'] . "</td>";
        echo "<td>" . $habitacion['tipo'] . "</td>";
        echo "<td>" . $habitacion['descripcion'] . "</td>";
        echo "<td>" . $habitacion['precio'] . "</td>";
        echo "<td>" . ($habitacion['disponible'] ? 'Sí' : 'No') . "</td>";
        echo "<td>" . ($habitacion['oferta'] ? 'Sí' : 'No') . "</td>";
        echo "<td>" . $habitacion['descuento'] . "%</td>";
        echo "<td><a href='editar_habitacion.php?id=" . $habitacion['id'] . "'>Editar</a> | <a href='eliminar_habitacion.php?id=" . $habitacion['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>