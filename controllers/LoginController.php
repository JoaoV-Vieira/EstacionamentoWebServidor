<?php
require_once __DIR__ . '/../models/Usuario.php';
session_start();

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if (!$email || !$senha) {
        $erro = "Preencha todos os campos corretamente.";
    } else {
        $usuario = Usuario::autenticar($email, $senha);

        if ($usuario instanceof Usuario) {
            // Login bem-sucedido, define variáveis de sessão
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['usuario_nome'] = $usuario->getNome();
            $_SESSION['usuario_administrador'] = $usuario->getAdministrador();

            header('Location: ../views/home.php');
            exit;
        } else {
            $erro = $usuario; // Mensagem de erro retornada pelo método autenticar
        }
    }
}

require __DIR__ . '/../views/login.php';
?>