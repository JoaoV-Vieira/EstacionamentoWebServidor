<?php
error_reporting(E_ALL & ~E_WARNING);
require_once __DIR__ . '/../autoload.php';

$usuarioId = $_SESSION['usuario_id'] ?? null;
$estacionamentos = [];
$veiculos = [];

if ($usuarioId) {
    $estacionamentos = Estacionamento::listarPorUsuario($usuarioId);
    $veiculos = Veiculo::listarDescricaoPorUsuario($usuarioId);
}

require_once __DIR__ . '/../views/home.php';