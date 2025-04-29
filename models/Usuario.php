<?php
require_once __DIR__ . '/../config/Conexao.php';

class Usuario {

    public static function cadastrar($nome, $email, $senhaHash, $administrador) {
        try {
            $conexao = Conexao::getConexao();

            $sqlVerificar = 'SELECT id FROM usuarios WHERE email = :email';
            $stmtVerificar = $conexao->prepare($sqlVerificar);
            $stmtVerificar->bindParam(':email', $email);
            $stmtVerificar->execute();

            if ($stmtVerificar->rowCount() > 0) {
                return false; 
            }

            $sqlInserir = 'INSERT INTO usuarios (nome, email, senha, administrador) VALUES (:nome, :email, :senha, :administrador)';
            $stmtInserir = $conexao->prepare($sqlInserir);
            $stmtInserir->bindParam(':nome', $nome);
            $stmtInserir->bindParam(':email', $email);
            $stmtInserir->bindParam(':senha', $senhaHash);
            $stmtInserir->bindParam(':administrador', $administrador);

            return $stmtInserir->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public static function autenticar($email, $senha) {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = Conexao::getConexao()->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$usuario) {
                return 'Usuário não encontrado.';
            }
    
            if (!password_verify($senha, $usuario['senha'])) {
                return 'Senha incorreta.';
            }
    
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_administrador'] = $usuario['administrador'];
            
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 'Erro ao autenticar o usuário.';
        }
    }
    
}
?>