<?php
require_once __DIR__ . '/../services/FipeService.php';
header('Content-Type: application/json');

$tipo = $_GET['tipo'] ?? '';
$fipe = new FipeService();
echo json_encode($fipe->getMarcas($tipo));