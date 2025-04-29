<?php
require_once __DIR__ . '/../config/Conexao.php';

class Usuario {

    public static function autenticar($email, $senha) {
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = Conexao::getConexao()->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Depuração: Verificar se o usuário foi encontrado
    if (!$usuario) {
        error_log("Usuário não encontrado para o email: $email");
        return false;
    }

    // Depuração: Verificar se a senha corresponde ao hash
    if (!password_verify($senha, $usuario['senha'])) {
        error_log("Senha incorreta para o email: $email");
        return false;
    }

    // Sessão iniciada com sucesso
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    return true;
}
    

    public static function cadastrar($nome, $email, $senha): bool {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = Conexao::getConexao()->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        return $stmt->execute([$nome, $email, $senhaHash]);
    }
}
?>