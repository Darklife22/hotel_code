<div?php
session_start();
require_once 'backend/funciones.php'; // Incluye las funciones de verificación de rol
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel - Inicio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <style>
        /* Estilos personalizados para mejorar el diseño */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-container {
            width: 100vw;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        #hero {
            padding: 100px 0;
        }

        #acerca-de-nosotros, #habitaciones, #opiniones, #contacto {
            padding: 60px 0;
        }

        .lead{
            color:green;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            object-fit: cover;
            height: 200px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        /* Fondo con efecto de difuminado */
        .welcome-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            width: 100vw; /* Asegura que ocupe todo el ancho de la ventana */
            background: linear-gradient(135deg, rgba(94, 94, 94, 0.7), rgba(71, 71, 71, 0.7)), 
                        url('/hotel_codigo/assets/img/hotel.jpg');
            background-blend-mode: overlay;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 20px;
        }

        /* Tarjeta de bienvenida */
        .welcome-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            text-align: center;
            position: relative;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Animación de aparición */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #carouselInstalaciones img {
            transition: transform 0.3s ease-in-out; /* Cambia 0.5s a 0.3s para una transición más rápida */
        }

        .carousel-item:hover img {
            transform: scale(1.05);
        }


        /* Icono principal según el rol */
        .icon-container {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .admin-icon {
            color: #ff4500;
        }

        .recepcion-icon {
            color: #007bff;
        }

        .client-icon {
            color: #28a745;
        }

        /* Texto */
        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        /* Contenedor de botones */
        .btn-container {
            display: flex;
            justify-content: center;
        }

        /* Botones personalizados */
        .custom-btn {
            background: linear-gradient(45deg, #ff7f50, #ff4500);
            border: none;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 25px;
            transition: 0.3s ease-in-out;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .custom-btn:hover {
            background: linear-gradient(45deg, #ff4500, #ff7f50);
            box-shadow: 0px 5px 15px rgba(255, 69, 0, 0.4);
            transform: scale(1.05);
        }

        .custom-btn i {
            font-size: 18px;
        }

        .carousel-inner img{
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <?php include 'partials/navbar.php'; ?>
        <main class="container-fluid mt-4 px-0">
            <?php if (isset($_SESSION['user_role'])): ?>
                <div class="welcome-container">
                    <div class="welcome-card">
                        <div class="icon-container">
                            <?php if (isAdmin()): ?>
                                <i class="fas fa-user-shield admin-icon"></i>
                            <?php elseif (isRecepcionista()): ?>
                                <i class="fas fa-concierge-bell recepcion-icon"></i>
                            <?php elseif (isCliente()): ?>
                                <i class="fas fa-hotel client-icon"></i>
                            <?php endif; ?>
                        </div>
                        <h2 class="card-title">¡Bienvenido, <?php echo $_SESSION['user_name']; ?>!</h2>
                        <p class="card-text">
                            <?php if (isAdmin()): ?>
                                Aquí puedes administrar todas las funciones y datos del hotel.
                            <?php elseif (isRecepcionista()): ?>
                                Aquí puedes registrar reservas y controlar a los clientes.
                            <?php elseif (isCliente()): ?>
                                Explora nuestras habitaciones y ofertas especiales.
                            <?php endif; ?>
                        </p>
                        <div class="btn-container">
                            <?php if (isAdmin()): ?>
                                <a href="views/admin/index.php" class="btn custom-btn">
                                    <i class="fas fa-user-shield"></i> Panel de administración
                                </a>
                            <?php elseif (isRecepcionista()): ?>
                                <a href="views/recepcionistas/index.php" class="btn custom-btn">
                                    <i class="fas fa-concierge-bell"></i> Panel de recepcionista
                                </a>
                            <?php elseif (isCliente()): ?>
                                <a href="views/cliente/index.php" class="btn custom-btn">
                                    <i class="fas fa-hotel"></i> Panel de cliente
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <section id="hero" class="py-5 bg-image" style="background-image: url('assets/img/imagen_hotel.jpg'); background-size: cover; background-position: center;">
                <div class="container text-center text-white">
                    <h1>Bienvenido al Hotel</h1>
                    <p class="lead">Disfruta de una experiencia inolvidable.</p>

                    <?php if (!isset($_SESSION['user_role'])): ?>
                        <a href="views/login.php" class="btn btn-primary btn-lg">Iniciar sesión para reservar</a>
                    <?php endif; ?>
                </div>
            </section>

            <section id="acerca-de-nosotros" class="py-5">
                <div class="container">
                    <h2 class="text-center">Acerca de nosotros</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                Somos un hotel familiar con más de 20 años de experiencia en la industria de la hospitalidad.
                                Nuestra misión es brindar a nuestros huéspedes una experiencia inolvidable, combinando
                                un servicio excepcional con instalaciones de primera clase.
                            </p>
                            <p>
                                Estamos ubicados en el corazón de la ciudad, a pocos minutos de los principales
                                atractivos turísticos.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div id="carouselInstalaciones" class="carousel slide" data-bs-ride="carousel" data-interval="1000"> <!-- Cambiado a 1000 ms -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="assets/img/restaurant.jpg" class="d-block w-100 rounded" alt="Restaurante">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/img/piscina.jpg" class="d-block w-100 rounded" alt="Piscina">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/img/spa.jpg" class="d-block w-100 rounded" alt="Spa">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/img/gimnasio.jpg" class="d-block w-100 rounded" alt="Gimnasio">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselInstalaciones" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselInstalaciones" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </section>

            <section id="habitaciones" class="py-5 bg-light">
                <div class="container">
                    <h2 class="text-center">Habitaciones</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="assets/img/simple.jpg" class="card-img-top" alt="Habitación individual">
                                <div class="card-body">
                                    <h3 class="card-title">Habitación individual</h3>
                                    <p class="card-text">Habitación individual con cama sencilla y baño privado.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="assets/img/duplex.jpg" class="card-img-top" alt="Habitación doble">
                                <div class="card-body">
                                    <h3 class="card-title">Habitación doble</h3>
                                    <p class="card-text">Habitación doble con dos camas individuales y baño privado.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="assets/img/suite.jpg" class="card-img-top" alt="Suite">
                                <div class="card-body">
                                    <h3 class="card-title">Suite</h3>
                                    <p class="card-text">Suite con cama king size, sala de estar y jacuzzi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!isset($_SESSION['user_role'])): ?>
                        <div class="text-center mt-4">
                            <a href="views/login.php" class="btn btn-primary">Iniciar sesión para reservar</a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section id="opiniones" class="py-5">
                <div class="container">
                    <h2 class="text-center">Opiniones de los huéspedes</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <p>"Excelente hotel, muy bien ubicado y con un servicio excepcional." - Juan Pérez</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <p>"Nos encantó nuestra estancia en este hotel, las habitaciones son muy cómodas y el personal es muy amable." - María García</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="contacto" class="py-5 bg-light">
                <div class="container">
                    <h2 class="text-center">Contacto</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="mensaje" class="form-label">Mensaje</label>
                                    <textarea class="form-control" id="mensaje" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <p>
                                Dirección: Calle Principal, 123<br>
                                Teléfono: +1 555 123 4567<br>
                                Correo electrónico: info@hotel.com
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php include 'partials/footer.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
