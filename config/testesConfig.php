<?php
require_once 'Conexao.php';

try {
    $conexao = Conexao::getConexao();
    echo 'Conexão bem-sucedida!';
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>