<?php
require_once __DIR__ . '/../models/Usuario.php';

session_start();
$acao = $_GET['acao'] ?? $_POST['acao'] ?? 'cadastrar';

$modalMensagem = '';
$modalTipo = '';

switch ($acao) {
    case 'excluir':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            Usuario::excluirPorId((int)$_POST['id']);
            $modalMensagem = "Usuário excluído com sucesso!";
            $modalTipo = 'success';
        }
        header('Location: /EstacionamentoWebServidor/cadastroUsuario');
        exit;

    case 'editar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $nome = trim($_POST['nome'] ?? '');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $administrador = isset($_POST['administrador']) ? 'S' : 'N';

            if (!$nome || !$email) {
                $modalMensagem = "Todos os campos são obrigatórios e o email deve ser válido.";
                $modalTipo = 'danger';
            } else {
                $usuario = new Usuario($nome, $email, $id, $administrador);
                if (!empty($_POST['senha'])) {
                    $usuario->setSenha($_POST['senha']);
                }
                if ($usuario->atualizar()) {
                    $modalMensagem = "Usuário atualizado com sucesso!";
                    $modalTipo = 'success';
                } else {
                    $modalMensagem = "Erro ao atualizar usuário.";
                    $modalTipo = 'danger';
                }
            }
        }
        header('Location: /EstacionamentoWebServidor/cadastroUsuario');
        exit;

    case 'cadastrar':
    default:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = $_POST['senha'] ?? '';
            $administrador = isset($_POST['administrador']) ? 'S' : 'N';

            if (!$nome || !$email || !$senha) {
                $modalMensagem = "Todos os campos são obrigatórios e o email deve ser válido.";
                $modalTipo = 'danger';
            } elseif (strlen($senha) < 8) {
                $modalMensagem = "A senha deve ter pelo menos 8 caracteres.";
                $modalTipo = 'danger';
            } else {
                try {
                    $usuario = new Usuario($nome, $email, null, $administrador);
                    $usuario->setSenha($senha);

                    if ($usuario->salvar()) {
                        $modalMensagem = "Usuário cadastrado com sucesso.";
                        $modalTipo = 'success';
                    } else {
                        $modalMensagem = "Erro ao cadastrar usuário. O email já pode estar cadastrado.";
                        $modalTipo = 'danger';
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    $modalMensagem = "Ocorreu um erro inesperado. Tente novamente mais tarde.";
                    $modalTipo = 'danger';
                }
            }
        }
        break;
}

require __DIR__ . '/../views/cadastroUsuario.php';
?>