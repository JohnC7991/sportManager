<?php
session_start();

// Si el usuario ya está logueado, redirigir al dashboard
if (isset($_SESSION["usuario"])) {
    header("Location: dashboard.php");
    exit();
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
                    <h2 class="text-center">Crear cuenta</h2>
                </div>
                <div class="card-body">
                    <form action="controller/registerController.php" method="POST">

                        <div class="mb-3">
                            <label for="id" class="form-label">Numero de Documento</label>
                            <input type="number" class="form-control" id="id" name="id" placeholder="Tu numero de documento" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                <option value="" selected disabled>Selecciona un tipo...</option>
                                <option value="CC">CC - Cédula de Ciudadanía</option>
                                <option value="TI">TI - Tarjeta de Identidad</option>
                                <option value="CE">CE - Cédula de Extranjería</option>
                                <option value="PAS">PAS - Pasaporte</option>
                                <option value="PEP">PEP - Permiso Especial de Permanencia</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_escuela" class="form-label">Id de Escuela</label>
                            <input type="number" class="form-control" id="id_escuela" name="id_escuela" placeholder="Nuemro de tu Escuela" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Tu nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Tus apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="tu@correo.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Tu telefono" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary w-100">Registrarse</button>
                    </form>

                    <?php if (isset($_GET["error"])):
                        $error = $_GET['error'];
                        $mensaje = 'Error desconocido.';
                        if ($error == 'empty') {
                            $mensaje = 'Todos los campos son obligatorios.';
                        } elseif ($error == 'db') {
                            $mensaje = 'Error al registrar. El documento o correo ya podría estar en uso.';
                        } elseif ($error == 'invalidemail') {
                            $mensaje = 'El formato del correo electrónico no es válido.';
                        }
                    ?>
                        <div class='mt-3 alert alert-danger text-center'><?php echo htmlspecialchars($mensaje); ?></div>
                    <?php endif; ?>

                    <?php if (isset($_GET["success"])): ?>
                        <div class='mt-3 alert alert-success text-center'>¡Registro exitoso! <a href="login.php">Inicia sesión aquí</a>.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>