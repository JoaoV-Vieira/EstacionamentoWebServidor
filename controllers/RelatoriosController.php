<?php
error_reporting(E_ALL & ~E_WARNING);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/Estacionamento.php';
require_once __DIR__ . '/../models/Veiculo.php';
require_once __DIR__ . '/../models/Usuario.php';

$tipo = $_GET['tipo'] ?? 'estacionamentos';

switch ($tipo) {
    case 'veiculos':
        $dadosRelatorio = Veiculo::listarTodos();
        $totalVeiculos = count($dadosRelatorio);
        $totalEstacionamentos = Estacionamento::contarTodos();
        $totalUsuarios = Usuario::contarTodos();
        break;
    case 'usuarios':
        $dadosRelatorio = Usuario::listarTodos();
        $totalUsuarios = count($dadosRelatorio);
        $totalEstacionamentos = Estacionamento::contarTodos();
        $totalVeiculos = Veiculo::contarTodos();
        break;
    case 'estacionamentos':
    default:
        $dadosRelatorio = Estacionamento::listarTodos();
        $totalEstacionamentos = count($dadosRelatorio);
        $totalVeiculos = Veiculo::contarTodos();
        $totalUsuarios = Usuario::contarTodos();
        break;
}

$tipoRelatorioSelecionado = $tipo;

require __DIR__ . '/../views/relatorios.php';
