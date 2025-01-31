<?php
include 'db.php';

function getUsers($conn) {
    $stmt = $conn->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function displayUsers($users) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>Email</th><th>Role</th><th>Actions</th></tr></thead>"; // Cambiado "Username" a "Email"
    echo "<tbody>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['email'] . "</td>"; // Usamos $user['email']
        echo "<td>" . $user['rol'] . "</td>";
        echo "<td><a href='editar_usuario.php?id=" . $user['id'] . "'>Editar</a> | <a href='eliminar_usuario.php?id=" . $user['id'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>