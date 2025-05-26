<?php
class Estacionamento {
    private $id;
    private $veiculo;
    private $local;
    private $dataHora;
    private $duracao;

    public function __construct($id = null, $veiculo, $local, $dataHora, $duracao) {
    $this->id = $id;
    $this->veiculo = $veiculo;
    $this->local = $local;
    $this->dataHora = $dataHora;
    $this->duracao = $duracao;
}

    public function getId() { return $this->id; }
    public function getVeiculo() { return $this->veiculo; }
    public function getLocal() { return $this->local; }
    public function getDataHora() { return $this->dataHora; }
    public function getDuracao() { return $this->duracao; }

    public function validarCamposObrigatorios(): bool {
        return !empty($this->veiculo) && !empty($this->local) && !empty($this->dataHora) && !empty($this->duracao);
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
}
?>