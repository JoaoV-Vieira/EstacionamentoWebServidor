<?php
require_once __DIR__ . '/../models/Veiculo.php';
require_once __DIR__ . '/../services/FipeService.php';

$mensagem = '';
$erro = '';

$fipe = new FipeService();

// Tipos disponíveis
$tipos = $fipe->getTipos(); // ['carros' => 'Carro', 'motos' => 'Moto', 'caminhoes' => 'Caminhão']

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = htmlspecialchars($_POST['tipo'] ?? '');
    $montadora = htmlspecialchars($_POST['montadora'] ?? '');
    $modelo = htmlspecialchars(trim($_POST['modelo'] ?? ''));
    $placa = htmlspecialchars(strtoupper(trim($_POST['placa'] ?? '')));

    $veiculo = new Veiculo($tipo, $montadora, $modelo, $placa);

    if (!$veiculo->validarCamposObrigatorios()) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!$veiculo->validarPlaca()) {
        $erro = "A placa deve estar no formato ABC-1234.";
    } else {
        $mensagem = "Veículo cadastrado com sucesso!";
    }
}

$montadoras = [
    ['id' => 1, 'descricao' => 'Fiat'],
    ['id' => 2, 'descricao' => 'Chevrolet'],
    ['id' => 3, 'descricao' => 'Volswagen'],
    ['id' => 4, 'descricao' => 'Renault'],
    ['id' => 5, 'descricao' => 'Peugeot']
];
?>