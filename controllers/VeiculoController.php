<?php
error_reporting(E_ALL & ~E_WARNING);
session_start();
require_once __DIR__ . '/../autoload.php';

$usuarioId = $_SESSION['usuario_id'] ?? null;
$acao = $_GET['acao'] ?? $_POST['acao'] ?? 'cadastrar';

$fipe = new FipeService();
$tipos = $fipe->getTipos();

switch ($acao) {
    case 'excluir':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            Veiculo::excluirPorId((int)$_POST['id']);
            $_SESSION['mensagem'] = "Veículo excluído com sucesso!";
        }
        header('Location: /EstacionamentoWebServidor/veiculosCadastrados');
        exit;

    case 'editar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $tipoKey = htmlspecialchars($_POST['tipo'] ?? '');
            $montadora = htmlspecialchars($_POST['montadora_nome'] ?? '');
            $modelo = htmlspecialchars(trim($_POST['modelo_nome'] ?? ''));
            $placa = htmlspecialchars(strtoupper(trim($_POST['placa'] ?? '')));
            $tipo = isset($tipos[$tipoKey]) ? $tipos[$tipoKey] : $tipoKey;

            $veiculo = new Veiculo($usuarioId, $tipo, $montadora, $modelo, $placa, $id);

            if (!$veiculo->validarCamposObrigatorios()) {
                $_SESSION['erro'] = "Todos os campos são obrigatórios.";
            } elseif (!$veiculo->validarPlaca()) {
                $_SESSION['erro'] = "A placa deve estar no formato ABC-1234.";
            } elseif (!$veiculo->atualizar()) {
                $_SESSION['erro'] = "Erro ao atualizar veículo.";
            } else {
                $_SESSION['mensagem'] = "Veículo atualizado com sucesso!";
            }
        }
        header('Location: /EstacionamentoWebServidor/veiculosCadastrados');
        exit;

    case 'cadastrar':
    default:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipoKey = htmlspecialchars($_POST['tipo'] ?? '');
            $montadora = htmlspecialchars($_POST['montadora_nome'] ?? '');
            $modelo = htmlspecialchars(trim($_POST['modelo_nome'] ?? ''));
            $placa = htmlspecialchars(strtoupper(trim($_POST['placa'] ?? '')));
            $tipo = isset($tipos[$tipoKey]) ? $tipos[$tipoKey] : $tipoKey;

            $veiculo = new Veiculo($usuarioId, $tipo, $montadora, $modelo, $placa);

            if (!$veiculo->validarCamposObrigatorios()) {
                $_SESSION['erro'] = "Todos os campos são obrigatórios.";
            } elseif (!$veiculo->validarPlaca()) {
                $_SESSION['erro'] = "A placa deve estar no formato ABC-1234.";
            } elseif (!$veiculo->salvar()) {
                $_SESSION['erro'] = "Erro ao cadastrar veículo. Verifique se a placa já está cadastrada.";
            } else {
                $_SESSION['mensagem'] = "Veículo cadastrado com sucesso!";
            }
        }
        break;
}

require __DIR__ . '/../views/cadastroVeiculo.php';
?>