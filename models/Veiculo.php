<?php
class Veiculo {
    private $tipo;
    private $montadora;
    private $modelo;
    private $placa;

    public function __construct($tipo, $montadora, $modelo, $placa) {
        $this->tipo = $tipo;
        $this->montadora = $montadora;
        $this->modelo = $modelo;
        $this->placa = strtoupper($placa);
    }

    public function validarCamposObrigatorios(): bool {
        return !empty($this->tipo) && !empty($this->montadora) && !empty($this->modelo) && !empty($this->placa);
    }

    public function validarPlaca(): bool {
        return preg_match('/^[A-Z]{3}-\d{4}$/', $this->placa);
    }
}
?>