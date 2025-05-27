<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/models/Estacionamento.php';
require_once __DIR__ . '/models/Veiculo.php';
// Adicione outros models conforme necessário

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tipo = $_GET['tipo'] ?? 'estacionamentos';
$usuarioId = $_SESSION['usuario_id'] ?? null;

if (!$usuarioId) {
    header('Location: /EstacionamentoWebServidor/login');
    exit;
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

switch ($tipo) {
    case 'veiculos':
        $dados = Veiculo::listarTodosPorUsuario($usuarioId);
        $sheet->setTitle('Veículos');
        // Cabeçalhos
        $sheet->fromArray(['#', 'Tipo', 'Placa', 'Modelo'], NULL, 'A1');
        // Dados
        $linha = 2;
        foreach ($dados as $veiculo) {
            $sheet->fromArray([
                $veiculo['id'],
                $veiculo['tipo'],
                $veiculo['placa'],
                $veiculo['modelo']
            ], NULL, "A$linha");
            $linha++;
        }
        $filename = 'veiculos.xlsx';
        break;

    case 'estacionamentos':
    default:
        $dados = Estacionamento::listarPorUsuario($usuarioId);
        $sheet->setTitle('Estacionamentos');
        // Cabeçalhos
        $sheet->fromArray(['#', 'Veículo', 'Local', 'Data e Hora', 'Duração', 'Estacionado até'], NULL, 'A1');
        // Dados
        $linha = 2;
        foreach ($dados as $estacionamento) {
            $sheet->fromArray([
                $estacionamento->getId(),
                $estacionamento->getVeiculo(),
                $estacionamento->getLocal(),
                date('d/m/Y H:i', strtotime($estacionamento->getDataHora())),
                $estacionamento->getDuracao(),
                $estacionamento->calcularEstacionadoAte()
            ], NULL, "A$linha");
            $linha++;
        }
        $filename = 'estacionamentos.xlsx';
        break;
}

// Envia para download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;