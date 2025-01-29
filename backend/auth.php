<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado['password'])) {
        $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
        $_SESSION['usuario_nombre'] = $usuarioEncontrado['usuario'];
        $_SESSION['rol'] = $usuarioEncontrado['rol'];

        // Redirigir según el rol
        switch ($_SESSION['rol']) {
            case 'admin':
                header('Location: ../views/admin.php');
                break;
            case 'recepcionista':
                header('Location: ../views/reservas.php');
                break;
            default: // Cliente u otro rol
                header('Location: ../index.php');
        }
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