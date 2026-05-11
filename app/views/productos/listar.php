<?php
$viewData = get_defined_vars();
$productos = is_array($viewData['productos'] ?? null) ? $viewData['productos'] : [];

if (!function_exists('normalize_image_src')) {
function normalize_image_src(string $value): string
{
    $value = trim($value);
    if ($value === '') {
        return '';
    }

    // Convert Windows paths to web paths
    $value = str_replace('\\', '/', $value);

    // If a full local path was pasted, try to keep only the project-relative part
    if (preg_match('~proyecto_crud/(.+)$~i', $value, $m)) {
        $value = $m[1];
    }

    // Allow absolute URLs and data URIs
    if (preg_match('~^(https?:)?//~i', $value) || str_starts_with($value, 'data:')) {
        return $value;
    }

    // Allow absolute paths from web root (e.g. /proyecto_crud/assets/img/a.jpg)
    if (str_starts_with($value, '/')) {
        return str_replace(' ', '%20', $value);
    }

    // If it's already a relative path (e.g. assets/img/a.jpg), keep it
    if (str_contains($value, '/')) {
        return str_replace(' ', '%20', $value);
    }

    // If it's just a filename, assume it's under assets/img/
    return 'assets/img/' . rawurlencode($value);
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="productos.php">Gestión de Productos</a>
        </div>
    </nav>

    <div class="container">
        <div class="mb-3">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Panel</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <h5 class="mb-0">Listado General</h5>
                <a href="productos.php?product_action=nuevo" class="btn btn-primary btn-sm fw-bold">
                    + Agregar Nuevo
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($productos)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No hay productos registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($productos as $p): ?>
                                <tr>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars((string)($p['id_producto'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span></td>
                                    <td class="fw-bold text-primary"><?= htmlspecialchars((string)($p['nombre'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>$<?= number_format((float)($p['precio'] ?? 0), 2) ?></td>
                                    <td class="text-muted"><?= htmlspecialchars((string)($p['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <?php $imgSrc = normalize_image_src((string)($p['imagen'] ?? '')); ?>
                                        <?php if ($imgSrc !== ''): ?>
                                            <img
                                                src="<?= htmlspecialchars($imgSrc) ?>"
                                                alt="<?= htmlspecialchars((string)($p['nombre'] ?? 'Producto'), ENT_QUOTES, 'UTF-8') ?>"
                                                class="img-thumbnail"
                                                style="width: 56px; height: 56px; object-fit: cover;"
                                            >
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="productos.php?product_action=editar&id=<?= urlencode((string)($p['id_producto'] ?? '')) ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                                            <a href="productos.php?product_action=eliminar&id=<?= urlencode((string)($p['id_producto'] ?? '')) ?>"
                                               class="btn btn-outline-danger btn-sm"
                                               onclick="return confirm('¿Seguro que quieres eliminarlo?')">Borrar</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
