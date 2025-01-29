<?php
session_start();
include '../backend/db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar el usuario
    $query = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$usuario]);
    $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioDB && password_verify($password, $usuarioDB['password'])) {
        // Si el login es correcto, guardar los datos del usuario en la sesión
        $_SESSION['usuario_id'] = $usuarioDB['id'];
        $_SESSION['usuario_rol'] = $usuarioDB['rol'];

        // Redirigir al usuario a la página de inicio o dashboard
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
