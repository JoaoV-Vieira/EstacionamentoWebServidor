<?php
require_once __DIR__ . '/../config/config.php';

class Usuario {

    public static function autenticar($email, $senha): bool {

        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id'] = $usuario['id'];
            return true;

        }

        return false;
    }

    public static function cadastrar($nome, $email, $senha): bool {

        global $pdo;
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        return $stmt->execute([$nome, $email, $senhaHash]);
    
    }
}
?>