<?php
session_start();

// Si el usuario no está logueado, se le redirige a la página de login.
if(!isset($_SESSION["usuario"])){
    header("Location: login.php");
    exit(); // Detener la ejecución del script.
}

require_once 'views/layout/header.php';
?>

<div class="container mt-5 mb-5">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["usuario"]); ?></h2>
    
    <p>Has iniciado sesión correctamente. Este es tu panel de control.</p>
</div>

<?php require_once 'views/layout/footer.php'; ?>