<?php
require_once __DIR__ . '/../models/Veiculo.php';

session_start();
$usuarioId = $_SESSION['usuario_id'] ?? null;
$veiculos = [];

if ($usuarioId) {
    $veiculos = Veiculo::listarTodosPorUsuario($usuarioId);
}

require __DIR__ . '/../views/veiculosCadastrados.php';