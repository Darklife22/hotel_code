<?php
include 'db.php';

function getRooms($conn) {
    $stmt = $conn->prepare("SELECT * FROM habitaciones");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displayRooms($rooms) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>Tipo</th><th>Descripción</th><th>Precio</th><th>Disponible</th><th>Acciones</th></tr></thead>"; // Columnas corregidas
    echo "<tbody>";
    foreach ($rooms as $room) {
        echo "<tr>";
        echo "<td>" . $room['id'] . "</td>";
        echo "<td>" . $room['tipo'] . "</td>";
        echo "<td>" . $room['descripcion'] . "</td>";
        echo "<td>" . $room['precio'] . "</td>";
        echo "<td>" . ($room['disponible'] ? 'Sí' : 'No') . "</td>";
        echo "<td><a href='editar_habitacion.php?id=" . $room['id'] . "'>Editar</a> | <a href='eliminar_habitacion.php?id=" . $room['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>