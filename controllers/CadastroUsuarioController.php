<?php
require_once __DIR__ . '/../models/Usuario.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';
    $administrador = isset($_POST['administrador']) ? 1 : 0;

    if (!$nome || !$email || !$senha) {
        $mensagem = "Todos os campos são obrigatórios.";
    } elseif (strlen($senha) < 8) {
        $mensagem = "A senha deve ter pelo menos 8 caracteres.";
    } else {
        try {
            $usuario = new Usuario($nome, $email, null, $administrador);
            $usuario->setSenha($senha);

            if ($usuario->salvar()) {
                $mensagem = "Usuário cadastrado com sucesso.";
            } else {
                $mensagem = "Erro ao cadastrar usuário. O email já pode estar cadastrado.";
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $mensagem = "Ocorreu um erro inesperado. Tente novamente mais tarde.";
        }
    }
}

require __DIR__ . '/../views/cadastroUsuario.php';
?>