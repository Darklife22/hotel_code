<?php
include '../backend/db.php';

// Obtener todos los usuarios
$query = "SELECT * FROM usuarios";
$stmt = $conn->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para mostrar los usuarios en una tabla (se usará en admin.php)
function obtenerUsuarios($conn) {
    try {
        $query = "SELECT * FROM usuarios";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log del error (importante para depuración)
        error_log("Error al obtener usuarios: ". $e->getMessage());
        // Manejo del error (muestra un mensaje amigable al usuario o redirige)
        die("Error al obtener usuarios. Por favor, inténtelo de nuevo más tarde."); // O mejor, una página de error personalizada.
    }
}
function mostrarUsuarios($usuarios) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Acciones</th></tr></thead>";
    echo "<tbody>";
    foreach ($usuarios as $usuario) {
        echo "<tr>";
        echo "<td>" . $usuario['id'] . "</td>";
        echo "<td>" . $usuario['usuario'] . "</td>";
        echo "<td>" . $usuario['rol'] . "</td>";
        echo "<td><a href='editar_usuario.php?id=" . $usuario['id'] . "'>Editar</a> | <a href='eliminar_usuario.php?id=" . $usuario['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>