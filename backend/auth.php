<?php
session_start(); // Inicia la sesión para poder usar $_SESSION

// Conexión a la base de datos
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Preparar la consulta para verificar el usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    // Verificar si el usuario existe
    $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado['password'])) {
        // Si el usuario y la contraseña son correctos
        $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
        $_SESSION['usuario_nombre'] = $usuarioEncontrado['usuario'];
        $_SESSION['rol'] = $usuarioEncontrado['rol']; // Puede ser 'cliente', 'recepcionista', 'admin'

        // Redirigir al inicio o página principal según el rol
        if ($_SESSION['rol'] == 'admin') {
            header('Location: ../views/admin.php');
        } elseif ($_SESSION['rol'] == 'recepcionista') {
            header('Location: ../views/reservas.php');
        } else {
            header('Location: ../views/inicio.php');
        }
        exit();
    } else {
        // Si el usuario o la contraseña son incorrectos
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!-- Formulario de inicio de sesión -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <h1>Iniciar sesión</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="auth.php">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>
