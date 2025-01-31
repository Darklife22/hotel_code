<?php require_once 'index.php'; ?>
<nav id="navbar" class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/hotel_codigo/index.php">
            <img src="/hotel_codigo/assets/img/hotel_logo.png" alt="Hotel" class="logo">
        </a>
        
        <!-- Botón de menú responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/hotel_codigo/index.php">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
                <?php if (isset($_SESSION['user_role'])): ?>
                    <?php if (isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/hotel_codigo/views/admin/index.php">
                                <i class="fas fa-user-shield"></i> Admin
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isRecepcionista()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/hotel_codigo/views/recepcionistas/index.php">
                                <i class="fas fa-concierge-bell"></i> Recepción
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isCliente()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/hotel_codigo/views/cliente/index.php">
                                <i class="fas fa-user"></i> Mi Cuenta
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link btn-logout" href="/hotel_codigo/partials/logout.php">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </a>
                    </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link btn-login" href="/hotel_codigo/views/login.php">
                        <i class="fas fa-sign-in-alt"></i> Ingresar
                    </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navbar compacto */
    .navbar {
        background: linear-gradient(135deg, #222, #474747);
        padding: 10px 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        height: 60px;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    /* Logo del navbar */
    .logo {
        height: 50px;
        transition: all 0.3s ease;
    }

    /* Estilos de los enlaces */
    .navbar-nav .nav-link {
        color: white !important;
        font-size: 0.95rem;
        padding: 8px 12px;
        border-radius: 5px;
        transition: 0.3s ease;
    }

    .nav-item {
        background: none;
        box-shadow: none;
    }

    /* Efecto hover en los enlaces */
    .navbar-nav .nav-link:hover {
        background: rgba(122, 122, 122, 0.7);
        color: white !important;
        transform: scale(1.03);
        text-decoration: none;
    }

    /* Botón de cerrar sesión */
    .btn-logout {
        background: red;
        color: white !important;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .btn-logout:hover {
        background: darkred;
    }

    /* Botón de login */
    .btn-login {
        background: #ff6600;
        color: white !important;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .btn-login:hover {
        background: #cc5200;
    }

    /* Navbar fijo al hacer scroll */
    .navbar.fixed {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 50px;
        padding: 5px 15px;
        background: rgba(34, 34, 34, 0.9);
        transition: all 0.3s ease;
    }

    .navbar.fixed .logo {
        height: 40px;
    }

    /* Navbar responsivo */
    @media (max-width: 768px) {
        .navbar-nav {
            text-align: center;
        }

        .navbar-nav .nav-link {
            display: block;
            margin: 5px 0;
        }

        .navbar {
            height: auto;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var navbar = document.getElementById("navbar");
        var body = document.body;
        var navbarHeight = navbar.offsetHeight;

        function ajustarPadding() {
            if (window.scrollY > 50) {
                navbar.classList.add("fixed");
                body.style.paddingTop = navbarHeight + "px"; // Ajusta el espacio dinámicamente
            } else {
                navbar.classList.remove("fixed");
                body.style.paddingTop = "0px"; // Remueve el espacio extra cuando está arriba
            }
        }

        window.addEventListener("scroll", ajustarPadding);
        ajustarPadding(); // Para aplicar el ajuste al cargar la página
    });
    (function() {
        let link = document.createElement('link');
        link.rel = 'icon';
        link.type = 'image/png';
        link.href = '/hotel_codigo/assets/img/hotel_logo.png'; // Ruta de tu favicon
        document.head.appendChild(link);
    })();
</script>
