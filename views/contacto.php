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

<h1>Contacto</h1>
<form method="POST">
    <label>ID Usuario:</label>
    <input type="text" name="id_usuario" required>
    <label>Mensaje:</label>
    <textarea name="mensaje" required></textarea>
    <button type="submit">Enviar</button>
</form>

<?php include '../partials/footer.php'; ?>