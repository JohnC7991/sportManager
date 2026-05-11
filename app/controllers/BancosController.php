<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\PayUService;
use Exception;

final class BancosController
{
    public function pseBanks(): void
    {
        header('Content-Type: application/json');

        try {
            $payu = new PayUService();
            $cfg = $payu->boot();

            // En sandbox, expone solo el banco de pruebas para evitar redirecciones a bancos reales.
            if (!empty($cfg['isTest']) && !empty($cfg['pseTestBankCode'])) {
                echo json_encode([
                    'status' => 'success',
                    'banks' => [[
                        'pseCode' => (string)$cfg['pseTestBankCode'],
                        'description' => (string)($cfg['pseTestBankName'] ?? 'Banco de pruebas (Sandbox)'),
                    ]],
                ]);
                return;
            }

            $banks = $payu->getPseBanks();
            if ($banks === []) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No hay bancos disponibles en este momento.',
                ]);
                return;
            }

            echo json_encode([
                'status' => 'success',
                'banks' => $banks,
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener la lista de bancos.',
                'details' => $e->getMessage(),
            ]);
        }
    }
}
