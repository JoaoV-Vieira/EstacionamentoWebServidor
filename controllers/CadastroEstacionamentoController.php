<?php
require_once '../config/Conexao.php';
require_once '../models/Estacionamento.php';

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $veiculo = htmlspecialchars($_POST['veiculo'] ?? '');
    $local = htmlspecialchars(trim($_POST['local'] ?? ''));
    $dataHora = htmlspecialchars($_POST['dataHora'] ?? '');
    $duracao = htmlspecialchars($_POST['duracao'] ?? '');

    $estacionamento = new Estacionamento(null, $veiculo, $local, $dataHora, $duracao);

    if (!$estacionamento->validarCamposObrigatorios()) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!$estacionamento->validarDataHoraFutura()) {
        $erro = "Não é possível estacionar em datas ou horas passadas.";
    } else {
        $mensagem = "Estacionamento cadastrado com sucesso! Duração: $duracao.";
        // $estacionadoAte será usado na view
        $estacionadoAte = $estacionamento->calcularEstacionadoAte();
    }
}

$veiculos = [
    ['id' => 1, 'descricao' => 'Moto - ABC-1234'],
    ['id' => 2, 'descricao' => 'Carro - DEF-5678'],
    ['id' => 3, 'descricao' => 'Caminhão - GHI-9012']
];
?>