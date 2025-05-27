<?php

class Veiculo {
    private $id;
    private $usuarioId;
    private $tipo;
    private $montadora;
    private $modelo;
    private $placa;

    public function __construct($usuarioId, $tipo, $montadora, $modelo, $placa, $id = null) {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->tipo = $tipo;
        $this->montadora = $montadora;
        $this->modelo = $modelo;
        $this->placa = strtoupper($placa);
    }

    public function getId() { return $this->id; }
    public function getUsuarioId() { return $this->usuarioId; }
    public function getTipo() { return $this->tipo; }
    public function getMontadora() { return $this->montadora; }
    public function getModelo() { return $this->modelo; }
    public function getPlaca() { return $this->placa; }

    public function validarCamposObrigatorios(): bool {
        return !empty($this->usuarioId) && !empty($this->tipo) && !empty($this->montadora) && !empty($this->modelo) && !empty($this->placa);
    }

    public function validarPlaca(): bool {
        return preg_match('/^[A-Z]{3}-\d{4}$/', $this->placa);
    }

    public function salvar() {
    try {
        $conexao = Conexao::getConexao();
        $sql = "INSERT INTO veiculos (usuario_id, tipo, montadora, modelo, placa) VALUES (:usuario_id, :tipo, :montadora, :modelo, :placa)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $this->usuarioId);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':montadora', $this->montadora);
        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':placa', $this->placa);
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

    public static function listarPorUsuario($usuarioId) {
        $conexao = Conexao::getConexao();
        $sql = "SELECT * FROM veiculos WHERE usuario_id = :usuario_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function buscarPorId($id, $usuarioId) {
        $conexao = Conexao::getConexao();
        $sql = "SELECT * FROM veiculos WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        $dados = $stmt->fetch();
        if ($dados) {
            return new Veiculo($dados['usuario_id'], $dados['tipo'], $dados['montadora'], $dados['modelo'], $dados['placa'], $dados['id']);
        }
        return null;
    }

    public function atualizar() {
        $conexao = Conexao::getConexao();
        $sql = "UPDATE veiculos SET tipo = :tipo, montadora = :montadora, modelo = :modelo, placa = :placa WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':montadora', $this->montadora);
        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':placa', $this->placa);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':usuario_id', $this->usuarioId);
        return $stmt->execute();
    }

    public static function excluir($id, $usuarioId) {
        $conexao = Conexao::getConexao();
        $sql = "DELETE FROM veiculos WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':usuario_id', $usuarioId);
        return $stmt->execute();
    }

    public static function excluirPorId($id) {
        $conexao = Conexao::getConexao();
        $sql = "DELETE FROM veiculos WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function listarDescricaoPorUsuario($usuarioId) {
        $conexao = Conexao::getConexao();
        $sql = "SELECT id, tipo, placa, modelo FROM veiculos WHERE usuario_id = :usuario_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        $veiculos = [];
        while ($row = $stmt->fetch()) {
            $veiculos[] = [
                'id' => $row['id'],
                'descricao' => "{$row['tipo']} - {$row['placa']} - {$row['modelo']}"
            ];
        }
        return $veiculos;
    }

    public static function buscarDescricaoPorId($id) {
        require_once __DIR__ . '/../config/Conexao.php';
        $conexao = Conexao::getConexao();
        $sql = "SELECT tipo, placa, modelo FROM veiculos WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            return "{$row['tipo']} - {$row['placa']} - {$row['modelo']}";
        }
        return 'Veículo não encontrado';
    }

    public static function listarTodosPorUsuario($usuarioId) {
        $conexao = Conexao::getConexao();
        $sql = "SELECT id, tipo, placa, modelo FROM veiculos WHERE usuario_id = :usuario_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodos() {
        $con = Conexao::getConexao();
        $stmt = $con->prepare("
            SELECT 
                v.id, 
                v.tipo, 
                v.placa, 
                v.modelo, 
                u.nome AS usuario
            FROM veiculos v
            JOIN usuarios u ON u.id = v.usuario_id
            ORDER BY v.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function contarTodos() {
        $con = Conexao::getConexao();
        $stmt = $con->query("SELECT COUNT(*) FROM veiculos");
        return (int)$stmt->fetchColumn();
    }
}
?>