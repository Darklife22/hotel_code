<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'administrador') {
    header("Location: ../../../index.php");
    exit();
}

include '../../../backend/db.php';
include '../../../partials/navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['usuario']; // Usar 'usuario' del formulario, que es el email
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña
    $rol = $_POST['rol'];

    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)"); // Insertar en 'email'
        $stmt->execute([$nombre, $email, $password, $rol]);

        header("Location: index.php"); // Redirigir a la lista de usuarios
        exit();
    } catch (PDOException $e) {
        $error_message = "Error al crear usuario: " . $e->getMessage();
        // Puedes mostrar $error_message en la página o registrarlo en un archivo de logs
        error_log($error_message); // Registrar el error en el log del servidor
    }
}
?>

<h1>Crear usuario</h1>

<?php if (isset($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<form method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>

    <label for="usuario">Email:</label>  <input type="text" name="usuario" id="usuario" required>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required>

    <label for="rol">Rol:</label>
    <select name="rol" id="rol">
        <option value="cliente">Cliente</option>
        <option value="recepcionista">Recepcionista</option>
        <option value="administrador">Administrador</option> </select>

    <button type="submit">Guardar</button>
</form>

<?php include '../../../partials/footer.php'; ?>