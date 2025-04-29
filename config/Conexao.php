<?php
class Conexao {
    private static $conexao;

    public static function getConexao() {
        if (!self::$conexao) {
            try {
                self::$conexao = new PDO('mysql:host=localhost;dbname=estacionamento', 'root', '');
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
            }
        }
        return self::$conexao;
    }
}
?>