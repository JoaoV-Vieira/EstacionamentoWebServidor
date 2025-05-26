<?php

require_once __DIR__ . '/../models/Estacionamento.php';

// Lista de estacionamentos (simulação, normalmente viria do banco)
$estacionamentos = [
    new Estacionamento(1, 'Carro - ABC-1234', 'Shopping Center', '2025-04-29T14:00', '2hr'),
    new Estacionamento(2, 'Moto - DEF-5678', 'Supermercado', '2025-04-29T15:30', '1h30min'),
    new Estacionamento(3, 'Caminhão - GHI-9012', 'Centro de Distribuição', '2025-04-29T16:00', '3hr'),
    new Estacionamento(4, 'Carro - JKL-3456', 'Estádio', '2025-04-29T17:00', '2h30min'),
    new Estacionamento(5, 'Moto - MNO-7890', 'Parque', '2025-04-29T18:00', '1hr'),
    new Estacionamento(6, 'Carro - PQR-1234', 'Aeroporto', '2025-04-29T19:00', '3hr'),
];

require_once __DIR__ . '/../views/home.php';