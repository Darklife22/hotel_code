<?php
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrador';
}

function isRecepcionista() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'recepcionista';
}

function isCliente() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'cliente';
}
?>