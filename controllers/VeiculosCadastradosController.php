<?php
error_reporting(E_ALL & ~E_WARNING);
require_once __DIR__ . '/../models/Veiculo.php';


$usuarioId = $_SESSION['usuario_id'] ?? null;
$veiculos = [];

if ($usuarioId) {
    $veiculos = Veiculo::listarTodosPorUsuario($usuarioId);
}

require __DIR__ . '/../views/veiculosCadastrados.php';