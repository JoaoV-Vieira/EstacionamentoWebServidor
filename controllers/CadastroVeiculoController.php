<?php

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = htmlspecialchars($_POST['tipo'] ?? '');
    $montadora = htmlspecialchars($_POST['montadora'] ?? '');
    $modelo = htmlspecialchars(trim($_POST['modelo'] ?? ''));
    $placa = htmlspecialchars(strtoupper(trim($_POST['placa'] ?? '')));

    if (empty($tipo) || empty($montadora) || empty($modelo) || empty($placa)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!preg_match('/^[A-Z]{3}-\d{4}$/', $placa)) {
        $erro = "A placa deve estar no formato ABC-1234.";
    } else {
        $mensagem = "Veículo cadastrado com sucesso!";
    }
}

$tipos = [
    ['id' => 1, 'descricao' => 'Moto'],
    ['id' => 2, 'descricao' => 'Carro'],
    ['id' => 3, 'descricao' => 'Caminhão']
];

$montadoras = [
    ['id' => 1, 'descricao' => 'Fiat'],
    ['id' => 2, 'descricao' => 'Chevrolet'],
    ['id' => 3, 'descricao' => 'Volswagen'],
    ['id' => 4, 'descricao' => 'Renault'],
    ['id' => 5, 'descricao' => 'Peugeot']
];
?>