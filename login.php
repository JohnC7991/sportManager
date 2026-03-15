<?php
session_start();

// Si el usuario ya está logueado, no debe ver esta página
if (isset($_SESSION["usuario"])) {
    header("Location: dashboard.php");
    exit(); // Detener la ejecución del script
}

require_once 'views/layout/header.php';
?>
<br>
<br>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2 class="text-center">Iniciar sesión</h2>
                </div>
                <div class="card-body">
                    <form action="controller/loginController.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="tu@correo.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Ingresar</button>
                    </form>
                    <?php if (isset($_GET["error"])): ?>
                        <p class='mt-3 text-danger text-center'>Usuario o contraseña incorrectos.</p>
                    <?php endif; ?>
                    <div class="mt-3 text-center">
                        <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'views/layout/footer.php';
?>