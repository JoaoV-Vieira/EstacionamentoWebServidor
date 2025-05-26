<?php
$title = 'Login';
require_once 'header.php';
?>

<div class="container-login">
    <h2>Login</h2>
    <?php if (!empty($erro)): ?>
        <p class="text-danger"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-outline-success">Entrar</button>
    </form>
</div>

<?php require_once 'footer.php'; ?>