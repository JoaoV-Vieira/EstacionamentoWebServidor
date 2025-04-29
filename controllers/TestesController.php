<?php
$senha = 'minhaSenha123';
$hash = password_hash($senha, PASSWORD_DEFAULT);

if (password_verify('minhaSenha123', $hash)) {
    echo "Senha válida";
} else {
    echo "Senha inválida";
}


require_once '/config/Conexao.php';

try {
    $conexao = Conexao::getConexao();
    echo 'Conexão bem-sucedida!';
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}