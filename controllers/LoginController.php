<?php
require_once __DIR__ . '/../models/Usuario.php';
session_start();

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if (!$email || !$senha) {

        $erro = "Preencha todos os campos corretamente.";

    } elseif (!Usuario::autenticar($email, $senha)) {

        $erro = "E-mail ou senha inválidos.";

    } else {

        header('Location: dashboard.php');

        exit;
    }
}
require __DIR__ . '/../views/login.php';
?>