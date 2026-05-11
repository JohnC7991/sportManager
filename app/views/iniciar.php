<?php
$viewData = get_defined_vars();
$transaction = is_array($viewData['transaction'] ?? null) ? $viewData['transaction'] : null;
$payuContext = is_array($viewData['payuContext'] ?? null) ? $viewData['payuContext'] : [];

if (!defined('APP_PATH')) {
    define('APP_PATH', dirname(__DIR__));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-3">Procesar pago</h2>

        <?php if (!empty($transaction) && is_array($transaction)): ?>
            <?php
            $estado = $transaction["estado"]["label"] ?? "Estado desconocido";
            $estadoCode = (int)($transaction["estado"]["code"] ?? 0);
            $alertClass = "alert-secondary";
            if ($estadoCode === 4) $alertClass = "alert-success";
            if ($estadoCode === 6 || $estadoCode === 104) $alertClass = "alert-danger";
            if ($estadoCode === 7) $alertClass = "alert-warning";
            ?>
            <div class="alert <?= htmlspecialchars($alertClass, ENT_QUOTES, "UTF-8") ?>">
                <strong>Resultado PayU:</strong> <?= htmlspecialchars($estado, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <?php require APP_PATH . "/views/partials/payu_form.php"; ?>
    </div>
</body>
</html>
