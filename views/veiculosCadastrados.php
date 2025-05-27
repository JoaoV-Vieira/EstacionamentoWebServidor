<?php
$title = 'Meus Veículos';
require_once 'header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <?php require_once 'sidebarUsuario.php'; ?>
        </div>
        <div class="col-md-9">
            <h3 class="d-flex justify-content-between align-items-center">
                Meus Veículos
                <a href="/EstacionamentoWebServidor/exportarExcel.php?tipo=estacionamentos" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Exportar Excel
                </a>
            </h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($veiculos) && is_array($veiculos) && count($veiculos)): ?>
                    <?php foreach ($veiculos as $veiculo): ?>
                        <tr>
                            <td><?php echo $veiculo['id']; ?></td>
                            <td><?php echo htmlspecialchars($veiculo['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($veiculo['placa']); ?></td>
                            <td><?php echo htmlspecialchars($veiculo['modelo']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="abrirEditarVeiculo(<?php echo $veiculo['id']; ?>)">
                                    <i class="bi bi-pencil text-white"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="abrirExcluirVeiculo(<?php echo $veiculo['id']; ?>)">
                                    <i class="bi bi-trash text-white"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum veículo cadastrado.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>