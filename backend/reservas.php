<?php
include '../backend/db.php';

// Obtener todas las reservas
$query = "SELECT * FROM reservas";
$stmt = $conn->prepare($query);
$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para mostrar las reservas en una tabla (se usará en admin.php)
function obtenerReservas($conn) {
    $query = "SELECT * FROM reservas";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function mostrarReservas($reservas) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>ID Cliente</th><th>ID Habitación</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estado</th><th>Acciones</th></tr></thead>";
    echo "<tbody>";
    foreach ($reservas as $reserva) {
        echo "<tr>";
        echo "<td>" . $reserva['id'] . "</td>";
        echo "<td>" . $reserva['id_cliente'] . "</td>";
        echo "<td>" . $reserva['id_habitacion'] . "</td>";
        echo "<td>" . $reserva['fecha_inicio'] . "</td>";
        echo "<td>" . $reserva['fecha_fin'] . "</td>";
        echo "<td>" . $reserva['estado'] . "</td>";
        echo "<td><a href='editar_reserva.php?id=" . $reserva['id'] . "'>Editar</a> | <a href='eliminar_reserva.php?id=" . $reserva['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>