<?php
session_start();
$title = 'Cadastro de Usuario';
require_once 'header.php';
?>
    <div class="container-cadastro">
    <h2>Cadastro de Usuário</h2>
    <?php if (!empty($mensagem)) echo "<p>$mensagem</p>"; ?>
    <?php if (!empty($erro)) echo "<p class='text-danger'>$erro</p>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="administrador" name="administrador">
                <label class="form-check-label" for="administrador">Administrador</label>
            </div>
            </div>
            <button type="submit" class="btn btn-outline-success">Cadastrar</button>
            <a href="home.php" class="btn btn-outline-secondary">Voltar</a>
        </form>
    </div>
<?php require_once 'footer.php'; ?>