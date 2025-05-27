<?php
class Estacionamento {
    private $id;
    private $usuarioId;
    private $veiculoId;
    private $local;
    private $dataHora;
    private $duracao;

    public function __construct($usuarioId, $veiculoId, $local, $dataHora, $duracao, $id = null) {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->veiculoId = $veiculoId;
        $this->local = $local;
        $this->dataHora = $dataHora;
        $this->duracao = $duracao;
    }

    public function getId() { return $this->id; }
    public function getUsuarioId() { return $this->usuarioId; }
    public function getVeiculoId() {
        return $this->veiculoId;
    }
    public function getLocal() { return $this->local; }
    public function getDataHora() { return $this->dataHora; }
    public function getDuracao() { return $this->duracao; }

    public function validarCamposObrigatorios(): bool {
        return !empty($this->usuarioId) && !empty($this->veiculoId) && !empty($this->local) && !empty($this->dataHora) && !empty($this->duracao);
    }

    public function validarDataHoraFutura(): bool {
        $dataHoraSelecionada = DateTime::createFromFormat('Y-m-d\TH:i', $this->dataHora);
        $dataHoraAtual = new DateTime();
        $dataHoraAtual->setTime((int)$dataHoraAtual->format('H'), (int)$dataHoraAtual->format('i'));
        return $dataHoraSelecionada > $dataHoraAtual;
    }

    public function calcularEstacionadoAte(): string {
        $horarioInicial = new DateTime($this->dataHora);
        $minutosAdicionais = match ($this->duracao) {
            '30min' => 30,
            '1hr' => 60,
            '1h30min' => 90,
            '2hr' => 120,
            '2h30min' => 150,
            '3hr' => 180,
            default => 0,
        };
        $horarioInicial->modify("+$minutosAdicionais minutes");
        return $horarioInicial->format('d/m/Y H:i');
    }

    public function salvar() {
        require_once __DIR__ . '/../config/Conexao.php';
        $conexao = Conexao::getConexao();
        $sql = "INSERT INTO estacionamentos (usuario_id, veiculo_id, local, data_hora, duracao)
                VALUES (:usuario_id, :veiculo_id, :local, :data_hora, :duracao)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $this->usuarioId);
        $stmt->bindParam(':veiculo_id', $this->veiculoId);
        $stmt->bindParam(':local', $this->local);
        $stmt->bindParam(':data_hora', $this->dataHora);
        $stmt->bindParam(':duracao', $this->duracao);
        return $stmt->execute();
    }

    public static function listarPorUsuario($usuarioId) {
        require_once __DIR__ . '/../config/Conexao.php';
        $conexao = Conexao::getConexao();
        $sql = "SELECT * FROM estacionamentos WHERE usuario_id = :usuario_id ORDER BY data_hora DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->execute();
        $resultados = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $estacionamento = new Estacionamento(
                $row['usuario_id'],
                $row['veiculo_id'],
                $row['local'],
                $row['data_hora'],
                $row['duracao'],
                $row['id']
            );
            $resultados[] = $estacionamento;
        }
        return $resultados;
    }

    public function getVeiculo() {
        require_once __DIR__ . '/Veiculo.php';
        return Veiculo::buscarDescricaoPorId($this->veiculoId);
    }

    public static function excluirPorId($id) {
        require_once __DIR__ . '/../config/Conexao.php';
        $conexao = Conexao::getConexao();
        $sql = "DELETE FROM estacionamentos WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function listarTodos() {
        require_once __DIR__ . '/../config/Conexao.php';
        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare("
            SELECT 
                e.id, 
                v.modelo AS veiculo, 
                e.local, 
                e.data_hora, 
                e.duracao, 
                u.nome AS usuario
            FROM estacionamentos e
            JOIN veiculos v ON v.id = e.veiculo_id
            JOIN usuarios u ON u.id = e.usuario_id
            ORDER BY e.data_hora DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function contarTodos() {
        require_once __DIR__ . '/../config/Conexao.php';
        $conexao = Conexao::getConexao();
        $stmt = $conexao->query("SELECT COUNT(*) FROM estacionamentos");
        return (int)$stmt->fetchColumn();
    }
}
?>