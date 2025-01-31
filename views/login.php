<?php
session_start();
include '../backend/db.php';

$error = null; // Inicializa la variable $error
$mensaje_registro = null; // Inicializa la variable $mensaje_registro

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['username'];
    $password = $_POST['password'];

    $user = null; // Inicializa $user a null

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error en la consulta: " . $e->getMessage();
        error_log("Error en la consulta: " . $e->getMessage());
    }

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];

            $redirect_url = match ($_SESSION['user_role']) {
                'administrador' => 'admin/index.php',
                'recepcionista' => 'recepcionistas/index.php', // Corregido el nombre del archivo
                'cliente' => 'cliente/index.php', // Corregido el nombre del archivo
                default => '../index.php',
            };
            header("Location: " . $redirect_url);
            exit();
        } else {
            $error = "Correo electrónico o contraseña incorrectos.";
        }
    } else {
        $error = "Correo electrónico o contraseña incorrectos."; // Usuario no encontrado
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $password, $rol]);

        $mensaje_registro = "Usuario registrado con éxito. Puedes iniciar sesión.";
    } catch (PDOException $e) {
        $error_registro = "Error en el registro: " . $e->getMessage(); // Captura el error de registro
        error_log("Error en el registro: " . $e->getMessage()); // Log del error
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

    <nav>
        <a href="/hotel_codigo/index.php">Inicio</a>
        <?php if (isset($_SESSION['user_role'])): ?>
            <?php if (isAdmin()): ?>
                <a href="/hotel_codigo/views/admin/index.php">Admin</a>
            <?php endif; ?>
            <?php if (isRecepcionista()): ?>
                <a href="/hotel_codigo/views/recepcionistas/index.php">Recepcionista</a>
            <?php endif; ?>
            <?php if (isCliente()): ?>
                <a href="/hotel_codigo/views/cliente/index.php">Cliente</a>
            <?php endif; ?>
            <a href="/hotel_codigo/partials/logout.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="/hotel_codigo/views/login.php">Iniciar sesión</a>
        <?php endif; ?>
    </nav>

    <h1>Iniciar sesión</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="login" value="1">
        <label for="username">Correo electrónico:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>

    <h2>Registrarse</h2>

    <?php if (isset($mensaje_registro)): ?>
        <p style="color: green;"><?php echo $mensaje_registro; ?></p>
    <?php endif; ?>
    <?php if (isset($error_registro)): ?>
        <p style="color: red;"><?php echo $error_registro; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="register" value="1">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="usuario">Correo electrónico:</label>
        <input type="text" name="usuario" id="usuario" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <label for="rol">Rol:</label>
        <select name="rol" id="rol">
            <option value="cliente">Cliente</option>
            <option value="recepcionista">Recepcionista</option>
        </select>

        <button type="submit">Registrarse</button>
    </form>

</body>
</html>