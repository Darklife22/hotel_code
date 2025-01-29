<?php
include '../backend/db.php';
include '../partials/navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $mensaje = $_POST['mensaje'];

    $query = "INSERT INTO contacto (id_usuario, mensaje) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id_usuario, $mensaje]);
    echo "Mensaje enviado con éxito.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <!-- Vinculamos el archivo CSS -->
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <h1>Contacto</h1>
    <form method="POST">
        <label>ID Usuario:</label>
        <input type="text" name="id_usuario" required>
        <label>Mensaje:</label>
        <textarea name="mensaje" required></textarea>
        <button type="submit">Enviar</button>
    </form>
<?php
include '../partials/footer.php';
?>
</body>
</html>
