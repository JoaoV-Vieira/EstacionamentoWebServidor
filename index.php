<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$route = $_GET['route'] ?? 'home';

$rotasPublicas = ['login', 'cadastro-usuario'];

if (!isset($_SESSION['usuario_id']) && !in_array($route, $rotasPublicas)) {
    header('Location: /EstacionamentoWebServidor/login');
    exit;
}

switch ($route) {
    case 'cadastroVeiculo':
        require __DIR__ . '/controllers/VeiculoController.php';
        break;
    case 'cadastroUsuario':
        require __DIR__ . '/controllers/UsuarioController.php';
        break;
    case 'cadastroEstacionamento':
        require __DIR__ . '/controllers/EstacionamentoController.php';
        break;
    case 'login':
        require __DIR__ . '/controllers/LoginController.php';
        break;
    case 'logout':
        require __DIR__ . '/controllers/LogoutController.php';
        break;
    case 'veiculosCadastrados':
        require __DIR__ . '/controllers/VeiculosCadastradosController.php';
        break;
    case 'relatorios':
        require __DIR__ . '/controllers/RelatoriosController.php';
        break;
    case 'home':
    default:
        require __DIR__ . '/controllers/homeController.php';
        break;
}
?>