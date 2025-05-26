<?php
require_once __DIR__ . '/../models/Veiculo.php';
require_once __DIR__ . '/../services/FipeService.php';

$usuarioId = $_SESSION['usuario_id'] ?? null;
$acao = $_GET['acao'] ?? $_POST['acao'] ?? 'cadastrar';

$modalMensagem = '';
$modalTipo = '';

$fipe = new FipeService();
$tipos = $fipe->getTipos();

switch ($acao) {
    case 'excluir':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            Veiculo::excluirPorId((int)$_POST['id']);
            $modalMensagem = "Veículo excluído com sucesso!";
            $modalTipo = 'success';
        }
        // Após exclusão, pode redirecionar ou recarregar a lista
        header('Location: /EstacionamentoWebServidor/cadastroVeiculo');
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
                $modalMensagem = "Todos os campos são obrigatórios.";
                $modalTipo = 'danger';
            } elseif (!$veiculo->validarPlaca()) {
                $modalMensagem = "A placa deve estar no formato ABC-1234.";
                $modalTipo = 'danger';
            } elseif (!$veiculo->atualizar()) {
                $modalMensagem = "Erro ao atualizar veículo.";
                $modalTipo = 'danger';
            } else {
                $modalMensagem = "Veículo atualizado com sucesso!";
                $modalTipo = 'success';
            }
        }
        header('Location: /EstacionamentoWebServidor/cadastroVeiculo');
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
                $modalMensagem = "Todos os campos são obrigatórios.";
                $modalTipo = 'danger';
            } elseif (!$veiculo->validarPlaca()) {
                $modalMensagem = "A placa deve estar no formato ABC-1234.";
                $modalTipo = 'danger';
            } elseif (!$veiculo->salvar()) {
                $modalMensagem = "Erro ao cadastrar veículo. Verifique se a placa já está cadastrada.";
                $modalTipo = 'danger';
            } else {
                $modalMensagem = "Veículo cadastrado com sucesso!";
                $modalTipo = 'success';
            }
        }
        break;
}

require __DIR__ . '/../views/cadastroVeiculo.php';
?>