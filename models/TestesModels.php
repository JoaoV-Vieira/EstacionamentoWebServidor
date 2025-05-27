<?php


class TestarUsuario {
    public static function consultarUsuario($email, $senha) {
        try {
            $conexao = Conexao::getConexao();

            $sql = 'SELECT * FROM usuarios WHERE email = :email AND senha = :senha';
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario ? $usuario : 'Usuário ou senha inválidos.';
        } catch (Exception $e) {
            return 'Erro: ' . $e->getMessage();
        }
    }
}

$email = 'novo@novo.com.br';
$senha = '123456789';

$resultado = TestarUsuario::consultarUsuario($email, $senha);

if (is_array($resultado)) {
    echo 'Usuário encontrado:';
    print_r($resultado);
} else {
    echo $resultado;
}
?>