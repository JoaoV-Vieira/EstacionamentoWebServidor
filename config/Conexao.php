<?php
class Conexao {
    private static ?PDO $conexao = null;

    // Impede instância direta
    private function __construct() {}
    // Impede clonagem
    private function __clone() {}
    // Impede desserialização
    public function __wakeup() {}

    /**
     * Retorna a instância PDO para conexão com o banco de dados.
     * @return PDO
     */
    public static function getConexao(): PDO {
        if (!self::$conexao) {
            try {
                self::$conexao = new PDO(
                    'mysql:host=localhost;dbname=estacionamento',
                    'root',
                    ''
                );
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
            }
        }
        return self::$conexao;
    }
}
?>