<?php
const DB_HOST = 'localhost';
const DB_NAME = 'estacionamento';
const DB_USER = 'root';
const DB_PASS = '';

try {
    self::$conexao = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS
    );
    self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>