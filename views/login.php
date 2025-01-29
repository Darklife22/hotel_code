<?php
session_start();
include '../backend/db.php';

// --- INICIO DE SESIÓN ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioDB && password_verify($password, $usuarioDB['password'])) {
            $_SESSION['usuario_id'] = $usuarioDB['id'];
            $_SESSION['usuario_rol'] = $usuarioDB['rol'];
            $_SESSION['usuario_nombre'] = $usuarioDB['nombre'];

            // Redirección con mensaje (usando JavaScript y una ventana modal)
            echo "<div class='modal fade show' id='bienvenidaModal' tabindex='-1' aria-labelledby='bienvenidaModalLabel' aria-hidden='true' style='display:block;'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='bienvenidaModalLabel'>¡Bienvenido!</h5>
                            </div>
                            <div class='modal-body'>
                                <p>Hola, " . $usuarioDB['nombre'] . ".</p>
                            </div>
                        </div>
                    </div>
                  </div>
                  <script>
                      setTimeout(function() {
                          window.location.href = '../views/admin.php'; // Redirige a la página correspondiente
                      }, 3000); // Redirige después de 3 segundos
                  </script>";
            exit();

        } else {
            $error = "Email o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        error_log("Error en el inicio de sesión: " . $e->getMessage());
        $error = "Error al iniciar sesión. Inténtelo más tarde.";
    }
}


// --- REGISTRO DE USUARIO ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // --- VALIDACIÓN DE DATOS ---
    if (empty($nombre) || empty($email) || empty($password)) {
        $error_registro = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_registro = "El email no es válido.";
    } elseif (strlen($password) < 6) {
        $error_registro = "La contraseña debe tener al menos 6 caracteres.";
    } // ... (Otras validaciones: usuario ya existe, etc.)

    if (!isset($error_registro)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$nombre, $email, $hashed_password, $rol]);

            $mensaje_registro = "Usuario creado correctamente. Puedes iniciar sesión.";
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            $error_registro = "Error al crear usuario. Inténtelo más tarde.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <style>
        body {
            padding-top: 50px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #343a40;
            text-align: center;
        }

        label {
            font-weight: 500;
            color: #343a40;
        }

        .form-control {
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .alert {
            margin-top: 10px;
        }

        .registro-form {
            margin-top: 20px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }

        /* Estilos para la ventana modal */
        .modal-content {
            animation: fadeInDown 1s ease-in-out; /* Animación de entrada */
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -100%, 0);
            }
            to {
                opacity: 1;
                transform: none;
            }
        }

        /* Estilos para la ventana modal */
        .modal-content {
            animation: fadeInDown 1s ease-in-out; /* Animación de entrada */
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -100%, 0);
            }
            to {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1>Iniciar Sesión</h1>

        <?php if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="login" value="1">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </form>

        <div class="registro-form">
            <h2>Crear Usuario</h2>

            <?php if (isset($error_registro)) {
                echo "<div class='alert alert-danger'>$error_registro</div>";
            } ?>
            <?php if (isset($mensaje_registro)) {
                echo "<div class='alert alert-success'>$mensaje_registro</div>";
            } ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="register" value="1">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select name="rol" id="rol" class="form-control">
                        <option value="cliente">Cliente</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Crear Usuario</button>
            </form>
        </div>
    </div>
</body>

</html>