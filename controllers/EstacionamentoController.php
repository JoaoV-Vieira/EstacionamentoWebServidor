<?php
error_reporting(E_ALL & ~E_WARNING);
require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/../models/Estacionamento.php';
require_once __DIR__ . '/../models/Veiculo.php';

session_start();

$usuarioId = $_SESSION['usuario_id'] ?? null;
$acao = $_GET['acao'] ?? $_POST['acao'] ?? 'cadastrar';

$mensagem = '';
$erro = '';

switch ($acao) {
    case 'excluir':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            Estacionamento::excluirPorId((int)$_POST['id']);
        }
        header('Location: /EstacionamentoWebServidor/home');
        exit;

    case 'editar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $veiculoId = htmlspecialchars($_POST['veiculo'] ?? '');
            $local = htmlspecialchars(trim($_POST['local'] ?? ''));
            $dataHora = htmlspecialchars($_POST['dataHora'] ?? '');
            $duracao = htmlspecialchars($_POST['duracao'] ?? '');

            $estacionamento = new Estacionamento($usuarioId, $veiculoId, $local, $dataHora, $duracao, $id);

            if (!$estacionamento->validarCamposObrigatorios()) {
                $_SESSION['erro'] = "Todos os campos são obrigatórios.";
            } elseif (!$estacionamento->validarDataHoraFutura()) {
                $_SESSION['erro'] = "Não é possível estacionar em datas ou horas passadas.";
            } else {
                if ($estacionamento->atualizar()) {
                    $_SESSION['mensagem'] = "Estacionamento atualizado com sucesso!";
                } else {
                    $_SESSION['erro'] = "Erro ao atualizar estacionamento.";
                }
            }
        }
        header('Location: /EstacionamentoWebServidor/home');
        exit;

    case 'cadastrar':
    default:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $veiculoId = htmlspecialchars($_POST['veiculo'] ?? '');
            $local = htmlspecialchars(trim($_POST['local'] ?? ''));
            $dataHora = htmlspecialchars($_POST['dataHora'] ?? '');
            $duracao = htmlspecialchars($_POST['duracao'] ?? '');

            $estacionamento = new Estacionamento($usuarioId, $veiculoId, $local, $dataHora, $duracao);

            if (!$estacionamento->validarCamposObrigatorios()) {
                $erro = "Todos os campos são obrigatórios.";
            } elseif (!$estacionamento->validarDataHoraFutura()) {
                $erro = "Não é possível estacionar em datas ou horas passadas.";
            } else {
                if ($estacionamento->salvar()) {
                    $mensagem = "Estacionamento cadastrado com sucesso! Duração: $duracao.";
                    $estacionadoAte = $estacionamento->calcularEstacionadoAte();
                } else {
                    $erro = "Erro ao salvar estacionamento no banco de dados.";
                }
            }
        }

        $veiculos = Veiculo::listarDescricaoPorUsuario($usuarioId);
        require __DIR__ . '/../views/cadastroEstacionamento.php';
        break;
}
?>