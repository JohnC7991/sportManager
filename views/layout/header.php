<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto SM</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <!-- Barra superior -->
    <div class="top-bar bg-dark text-white py-1">
        <div class="container d-flex justify-content-between">
            <span>Email: contacto@proyecto.com | Tel: +123 456 789</span>
            <div>
                <a href="#" class="text-white me-2">Facebook</a>
                <a href="#" class="text-white me-2">Twitter</a>
                <a href="#" class="text-white">Instagram</a>
            </div>
        </div>
    </div>

    <!-- Navbar flotante -->
<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/img/logo_icoaner.jpg" alt="Logo" class="logo-nav me-2">
            <span>Proyecto SM</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php#sobre-nosotros">Sobre nosotros</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#planes">Planes</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#beneficios">Beneficios</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#contacto">Contacto</a></li>
                
                <?php if (isset($_SESSION["usuario"])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hola, <?php echo htmlspecialchars($_SESSION["usuario"]); ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="dashboard.php">Mi Panel</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="startDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Iniciar
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="startDropdown">
                        <li><a class="dropdown-item" href="login.php">Iniciar sesión</a></li>
                        <li><a class="dropdown-item" href="register.php">Registrarse</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

</header>

    <main>