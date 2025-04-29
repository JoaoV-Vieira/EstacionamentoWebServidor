<?php

function calcularEstacionadoAte($dataHora, $duracao) {
    $horarioInicial = new DateTime($dataHora);
    $minutosAdicionais = 0;

    switch ($duracao) {
        case '30min':
            $minutosAdicionais = 30;
            break;
        case '1hr':
            $minutosAdicionais = 60;
            break;
        case '1h30min':
            $minutosAdicionais = 90;
            break;
        case '2hr':
            $minutosAdicionais = 120;
            break;
        case '2h30min':
            $minutosAdicionais = 150;
            break;
        case '3hr':
            $minutosAdicionais = 180;
            break;
    }

    $horarioInicial->modify("+$minutosAdicionais minutes");
    return $horarioInicial->format('d/m/Y H:i');
}

$estacionamentos = [
    ['id' => 1, 'veiculo' => 'Carro - ABC-1234', 'local' => 'Shopping Center', 'dataHora' => '2025-04-29T14:00', 'duracao' => '2hr'],
    ['id' => 2, 'veiculo' => 'Moto - DEF-5678', 'local' => 'Supermercado', 'dataHora' => '2025-04-29T15:30', 'duracao' => '1h30min'],
    ['id' => 3, 'veiculo' => 'Caminhão - GHI-9012', 'local' => 'Centro de Distribuição', 'dataHora' => '2025-04-29T16:00', 'duracao' => '3hr'],
    ['id' => 4, 'veiculo' => 'Carro - JKL-3456', 'local' => 'Estádio', 'dataHora' => '2025-04-29T17:00', 'duracao' => '2h30min'],
    ['id' => 5, 'veiculo' => 'Moto - MNO-7890', 'local' => 'Parque', 'dataHora' => '2025-04-29T18:00', 'duracao' => '1hr'],
    ['id' => 6, 'veiculo' => 'Carro - PQR-1234', 'local' => 'Aeroporto', 'dataHora' => '2025-04-29T19:00', 'duracao' => '3hr'],
];

require_once __DIR__ . '/../views/home.php';