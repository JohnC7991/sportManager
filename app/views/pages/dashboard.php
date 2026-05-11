<?php
$viewData = get_defined_vars();
$events = is_array($viewData['events'] ?? null) ? $viewData['events'] : [];
$athletes = is_array($viewData['athletes'] ?? null) ? $viewData['athletes'] : [];
$rol = (int)($viewData['rol'] ?? ($_SESSION['rol'] ?? 0));
$rolLabel = (string)($_SESSION['nombre_rol'] ?? '');
if ($rolLabel === '') {
    $rolLabel = [1 => 'Acudiente', 2 => 'Entrenador', 3 => 'Administrador'][$rol] ?? 'Usuario';
}
?>
<br>
<br>
<div class="dashboard position-relative">
    <div class="rol-box"><?= htmlspecialchars($rolLabel) ?></div>

    <?php foreach ($events as $e): ?>
        <div class="alert alert-success alert-fijo" id="eventoAlert<?= (int)$e->id_evento ?>">
            <span><?= htmlspecialchars($e->titulo . ' - ' . $e->fecha) ?></span>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#evento<?= (int)$e->id_evento ?>">Ver</button>
        </div>

        <div class="modal fade modal-top-right" id="evento<?= (int)$e->id_evento ?>" tabindex="-1" data-bs-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= htmlspecialchars((string)$e->titulo) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Fecha:</b> <?= htmlspecialchars((string)$e->fecha) ?></p>
                        <p><b>Tipo:</b> <?= htmlspecialchars((string)$e->tipo_evento) ?></p>
                        <p><b>Costo:</b> $<?= htmlspecialchars((string)$e->costo) ?></p>
                    </div>
                    <div class="modal-footer">
                        <span class="me-auto">Inscritos: <b id="count<?= (int)$e->id_evento ?>"><?= (int)$e->total_inscritos ?></b></span>
                        <a href="index.php?url=iniciar&evento=<?= urlencode((string)$e->titulo) ?>&monto=<?= urlencode((string)$e->costo) ?>&cantidad=1" class="btn btn-warning">Pagar</a>
                        <?php if ($e->inscrito): ?>
                            <button class="btn btn-success" disabled>Ya inscrito</button>
                        <?php else: ?>
                            <button class="btn btn-primary btnInscribirseEvento" data-evento="<?= (int)$e->id_evento ?>" data-athletes-count="<?= count($athletes) ?>">Inscribirse</button>
                        <?php endif; ?>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-top-right" id="seleccionarDeportista<?= (int)$e->id_evento ?>" tabindex="-1" data-bs-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccionar Deportista</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (count($athletes) > 0): ?>
                            <select class="form-control selectDeportista" data-evento="<?= (int)$e->id_evento ?>">
                                <option value="">Seleccione...</option>
                                <?php foreach ($athletes as $d): ?>
                                    <option value="<?= htmlspecialchars((string)$d->id_deportista, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($d->nombres . ' ' . $d->apellidos) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <p>No tienes deportistas registrados</p>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btnConfirmarInscripcion" data-evento="<?= (int)$e->id_evento ?>">Confirmar</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="subtitulo">
        <h2>BIENVENIDO, <?= htmlspecialchars(($_SESSION['usuario']['nombres'] ?? '') . ' ' . ($_SESSION['usuario']['apellidos'] ?? '')) ?></h2>
    </div>
    <br>

    <div class="opciones">
        <?php if ($rol === 3): ?>
            <a href="admin_usuarios.php" class="card-dashboard">Gestionar Usuarios</a>
            <a href="deportistas.php" class="card-dashboard">Gestionar Deportistas</a>
            <a href="index.php?action=listar" class="card-dashboard">Reporte de Facturas</a>
            <a href="productos.php" class="card-dashboard">Productos</a>
            <a href="reportes.php" class="card-dashboard">Reportes Generales</a>
            <a href="gestion_eventos.php" class="card-dashboard">Eventos</a>
        <?php elseif ($rol === 2): ?>
            <a href="deportistas.php" class="card-dashboard">Ver Deportistas</a>
            <a href="index.php?url=registrar-asistencia" class="card-dashboard">Registrar Asistencia</a>
            <a href="reportes.php" class="card-dashboard">Reportes</a>
        <?php else: ?>
            <a href="deportistas.php" class="card-dashboard">Registrar Deportista</a>
            <a href="pagos.php" class="card-dashboard">Mis Pagos</a>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function registrarInscripcion(id_evento, id_deportista) {
            fetch("inscribirse.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id_evento=" + encodeURIComponent(id_evento) + "&id_deportista=" + encodeURIComponent(id_deportista)
            }).then(res => res.text()).then(data => {
                if (data === "ok") {
                    location.reload();
                } else {
                    alert(data);
                }
            });
        }

        document.querySelectorAll(".btnInscribirseEvento").forEach(btn => {
            btn.addEventListener("click", function() {
                const id_evento = this.dataset.evento;
                const athletesCount = parseInt(this.dataset.athletesCount || "0", 10);
                const select = document.querySelector(`.selectDeportista[data-evento='${id_evento}']`);

                if (athletesCount <= 0 || !select) {
                    alert("No tienes deportistas registrados");
                    return;
                }

                if (athletesCount === 1) {
                    const unicaOpcion = Array.from(select.options).find(opt => opt.value !== "");
                    if (!unicaOpcion) {
                        alert("No tienes deportistas disponibles");
                        return;
                    }
                    registrarInscripcion(id_evento, unicaOpcion.value);
                    return;
                }

                const modalEl = document.getElementById(`seleccionarDeportista${id_evento}`);
                if (modalEl) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            });
        });

        document.querySelectorAll(".btnConfirmarInscripcion").forEach(btn => {
            btn.addEventListener("click", function() {
                const id_evento = this.dataset.evento;
                const select = document.querySelector(`.selectDeportista[data-evento='${id_evento}']`);
                const id_deportista = select ? select.value : "";
                if (!id_deportista) {
                    alert("Selecciona un deportista");
                    return;
                }
                registrarInscripcion(id_evento, id_deportista);
            });
        });
    });
</script>
