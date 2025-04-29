<!DOCTYPE html>
<html>
<head><title>Cadastro de Usuário</title></head>
<body>
    <h2>Cadastro de Usuário</h2>
    <?php if (!empty($mensagem)) echo "<p>$mensagem</p>"; ?>
    <form method="POST">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>