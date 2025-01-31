<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'administrador') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../partials/navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            echo "Usuario no encontrado.";
            exit();
        }
    } catch (PDOException $e) {
        $error_message = "Error al obtener usuario: " . $e->getMessage();
        error_log($error_message);
        echo $error_message; // Muestra el mensaje de error (o puedes redirigir)
        exit();
    }
} else {
    echo "ID de usuario no especificado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['usuario'];  // Usar 'usuario' del formulario (que es el email)
    $rol = $_POST['rol'];

    try {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?"); // Actualizar 'email'
        $stmt->execute([$nombre, $email, $rol, $id]);

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $error_message = "Error al actualizar usuario: " . $e->getMessage();
        error_log($error_message);
        echo $error_message; // Muestra el mensaje de error
    }
}
?>

<h1>Editar usuario</h1>

<form method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

    <label for="usuario">Email:</label>
    <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

    <label for="rol">Rol:</label>
    <select name="rol" id="rol">
        <option value="cliente" <?php if ($usuario['rol'] == 'cliente') echo 'selected'; ?>>Cliente</option>
        <option value="recepcionista" <?php if ($usuario['rol'] == 'recepcionista') echo 'selected'; ?>>Recepcionista</option>
        <option value="administrador" <?php if ($usuario['rol'] == 'administrador') echo 'selected'; ?>>Administrador</option>
    </select>

    <button type="submit">Guardar cambios</button>
</form>

<?php include '../../../partials/footer.php'; ?>