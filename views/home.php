<?php
session_start();
/*if (!isset($_SESSION['usuario_nome'])) {
    header('Location: login.php');
    exit;
}*/
$title = 'Home';
require_once 'header.php';
?>
<div class="container mt-5">
    <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h2>
    <p>Você está na página inicial do sistema.</p>
    <a href="logout.php" class="btn btn-danger">Sair</a>
</div>
<?php require_once 'footer.php'; ?>