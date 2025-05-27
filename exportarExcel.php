<?php
error_reporting(E_ALL & ~E_WARNING);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/models/Estacionamento.php';
require_once __DIR__ . '/models/Veiculo.php';
require_once __DIR__ . '/models/Usuario.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tipo = $_GET['tipo'] ?? 'estacionamentos';

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

switch ($tipo) {
    case 'usuarios':
        $dados = Usuario::listarTodos();
        $sheet->setTitle('Usuários');
        $sheet->fromArray(['#', 'Nome', 'Email', 'Administrador'], NULL, 'A1');
        $linha = 2;
        foreach ($dados as $usuario) {
            $sheet->fromArray([
                $usuario['id'],
                $usuario['nome'],
                $usuario['email'],
                $usuario['administrador'] === 'S' ? 'Sim' : 'Não'
            ], NULL, "A$linha");
            $linha++;
        }
        $filename = 'usuarios.xlsx';
        break;

    case 'veiculos':
        $dados = Veiculo::listarTodos();
        $sheet->setTitle('Veículos');
        $sheet->fromArray(['#', 'Tipo', 'Placa', 'Modelo', 'Usuário'], NULL, 'A1');
        $linha = 2;
        foreach ($dados as $veiculo) {
            $sheet->fromArray([
                $veiculo['id'],
                $veiculo['tipo'],
                $veiculo['placa'],
                $veiculo['modelo'],
                $veiculo['usuario'] ?? ''
            ], NULL, "A$linha");
            $linha++;
        }
        $filename = 'veiculos.xlsx';
        break;

    case 'estacionamentos':
    default:
        $dados = Estacionamento::listarTodos();
        $sheet->setTitle('Estacionamentos');
        $sheet->fromArray(['#', 'Veículo', 'Local', 'Data e Hora', 'Duração', 'Usuário'], NULL, 'A1');
        $linha = 2;
        foreach ($dados as $estacionamento) {
            $sheet->fromArray([
                $estacionamento['id'],
                $estacionamento['veiculo'],
                $estacionamento['local'],
                $estacionamento['data_hora'],
                $estacionamento['duracao'],
                $estacionamento['usuario'] ?? ''
            ], NULL, "A$linha");
            $linha++;
        }
        $filename = 'estacionamentos.xlsx';
        break;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;