<?php
require_once '../config/Conexao.php';

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $veiculo = htmlspecialchars($_POST['veiculo'] ?? '');
    $local = htmlspecialchars(trim($_POST['local'] ?? ''));
    $dataHora = htmlspecialchars($_POST['dataHora'] ?? '');
    $duracao = htmlspecialchars($_POST['duracao'] ?? '');

    if (empty($veiculo) || empty($local) || empty($dataHora) || empty($duracao)) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        $dataHoraSelecionada = DateTime::createFromFormat('Y-m-d\TH:i', $dataHora);
        $dataHoraAtual = new DateTime();
        $dataHoraAtual->setTime((int)$dataHoraAtual->format('H'), (int)$dataHoraAtual->format('i'));

        if ($dataHoraSelecionada <= $dataHoraAtual) {
            $erro = "Não é possível estacionar em datas ou horas passadas.";
        } else {
            $mensagem = "Estacionamento cadastrado com sucesso! Duração: $duracao.";
        }
    }
}

$veiculos = [
    ['id' => 1, 'descricao' => 'Moto - ABC-1234'],
    ['id' => 2, 'descricao' => 'Carro - DEF-5678'],
    ['id' => 3, 'descricao' => 'Caminhão - GHI-9012']
];
?>