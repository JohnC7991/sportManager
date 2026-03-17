<?php
session_start();

// Si ya hay sesión activa, redirigir (opcional)
if (isset($_SESSION["usuario"])) {
    header("Location: dashboard.php");
    exit();
}

require_once 'views/layout/header.php';
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Registro de Escuela</h2>
                </div>
                <div class="card-body">
                    <form action="controller/registroEscuelaController.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_escuela" class="form-label">ID de Escuela</label>
                                <input type="number" class="form-control" id="id_escuela" name="id_escuela" placeholder="Ej. 1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la escuela" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="disciplina" class="form-label">Disciplina</label>
                            <input type="text" class="form-control" id="disciplina" name="disciplina" placeholder="Fútbol, Baloncesto, etc." required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="dia_pago" class="form-label">Día de pago</label>
                                <input type="number" min="1" max="31" class="form-control" id="dia_pago" name="dia_pago" placeholder="30" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="valor_inscripcion" class="form-label">Valor inscripción</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="valor_inscripcion" name="valor_inscripcion" placeholder="45000" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="valor_mensualidad" class="form-label">Valor mensualidad</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="valor_mensualidad" name="valor_mensualidad" placeholder="40000" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pass_app" class="form-label">Contraseña App</label>
                                <input type="password" class="form-control" id="pass_app" name="pass_app" placeholder="Contraseña segura" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="3111111111" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle 123 #45-67" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="escudo_path" class="form-label">Escudo (archivo)</label>
                                <input type="file" class="form-control" id="escudo_path" name="escudo_path" accept="image/*">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firma_path" class="form-label">Firma (archivo)</label>
                                <input type="file" class="form-control" id="firma_path" name="firma_path" accept="image/*">
                            </div>
                        </div>

                        <button type="submit" name="submit_escuela" class="btn btn-primary w-100">Registrar Escuela</button>
                    </form>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center mt-3">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success text-center mt-3">
                            <?php echo htmlspecialchars($_GET['success']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>
