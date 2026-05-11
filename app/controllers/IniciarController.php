<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

final class IniciarController
{
    public function show(): void
    {
        $transaction = null;
        if (!empty($_SESSION['flash_transaction']) && is_array($_SESSION['flash_transaction'])) {
            $transaction = $_SESSION['flash_transaction'];
            unset($_SESSION['flash_transaction']);
        }

        $eventoTitulo = (string)($_GET['evento'] ?? 'Pago');
        $monto = isset($_GET['monto']) ? (float)$_GET['monto'] : 0.0;
        $cantidad = isset($_GET['cantidad']) ? max(1, (int)$_GET['cantidad']) : 1;

        $usuarioSesion = $_SESSION['usuario'] ?? [];
        $nombreUsuario = trim((string)($usuarioSesion['nombres'] ?? '') . ' ' . (string)($usuarioSesion['apellidos'] ?? ''));
        $emailUsuario = (string)($usuarioSesion['email'] ?? '');
        $telefonoUsuario = (string)($usuarioSesion['telefono'] ?? '');

        if (!isset($_SESSION['registro_temporal']) || !is_array($_SESSION['registro_temporal'])) {
            $_SESSION['registro_temporal'] = [
                'nombre' => $nombreUsuario,
                'email' => $emailUsuario,
                'telefono' => $telefonoUsuario,
                'password' => '',
            ];
        }

        $payuContext = [
            'evento_titulo' => $eventoTitulo,
            'monto' => $monto,
            'cantidad' => $cantidad,
            'action' => 'procesar_pago.php',
            'return_to' => 'index.php?url=iniciar',
            'error' => $_SESSION['error'] ?? '',
            'prefill' => [
                'nombre' => $nombreUsuario,
            ],
        ];
        unset($_SESSION['error']);

        View::render('iniciar', [
            'transaction' => $transaction,
            'payuContext' => $payuContext,
        ]);
    }
}
