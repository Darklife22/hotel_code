<?php
include 'db.php';

function getReservations($conn) {
    $stmt = $conn->prepare("SELECT * FROM reservas");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displayReservations($reservations) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>ID Cliente</th><th>ID Habitación</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Estado</th><th>Acciones</th></tr></thead>";
    echo "<tbody>";
    foreach ($reservations as $reservation) {
        echo "<tr>";
        echo "<td>" . $reservation['id'] . "</td>";
        echo "<td>" . $reservation['id_cliente'] . "</td>";
        echo "<td>" . $reservation['id_habitacion'] . "</td>";
        echo "<td>" . $reservation['fecha_inicio'] . "</td>";
        echo "<td>" . $reservation['fecha_fin'] . "</td>";
        echo "<td>" . $reservation['estado'] . "</td>";
        echo "<td><a href='editar_reserva.php?id=" . $reservation['id'] . "'>Editar</a> | <a href='eliminar_reserva.php?id=" . $reservation['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>