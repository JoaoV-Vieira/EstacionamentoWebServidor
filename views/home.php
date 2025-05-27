<?php

$title = 'Home';
require_once 'header.php';
?>

<div class="container mt-5">
    <div class="row">
        <!-- Coluna da esquerda: Informações do usuário -->
        <div class="col-md-3">
            <?php require_once 'sidebarUsuario.php'; ?>
        </div>

        <!-- Coluna da direita: Lista de estacionamentos -->
        <div class="col-md-9">
            <h3 class="d-flex justify-content-between align-items-center">
                Estacionamentos Cadastrados
                <a href="/EstacionamentoWebServidor/exportarExcel.php?tipo=estacionamentos" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Exportar
                </a>
            </h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Veículo</th>
                        <th>Local</th>
                        <th>Data e Hora</th>
                        <th>Duração</th>
                        <th>Estacionado até</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($estacionamentos) && is_array($estacionamentos)): ?>
                    <?php foreach ($estacionamentos as $estacionamento): ?>
                        <tr>
                            <td><?php echo $estacionamento->getId(); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento->getVeiculo()); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento->getLocal()); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($estacionamento->getDataHora())); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento->getDuracao()); ?></td>
                            <td><?php echo $estacionamento->calcularEstacionadoAte(); ?></td>
                            <td>
                                <?php
                                    $estacionadoAteStr = $estacionamento->calcularEstacionadoAte();
                                    $estacionadoAte = DateTime::createFromFormat('d/m/Y H:i', $estacionadoAteStr);
                                    $agora = new DateTime();
                                    if ($estacionadoAte > $agora):
                                ?>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal"
                                            onclick="preencherFormulario(
                                                <?php echo $estacionamento->getId(); ?>,
                                                <?php echo $estacionamento->getVeiculoId(); ?>,
                                                '<?php echo htmlspecialchars($estacionamento->getLocal()); ?>',
                                                '<?php echo $estacionamento->getDataHora(); ?>',
                                                '<?php echo $estacionamento->getDuracao(); ?>'
                                            )">
                                        <i class="bi bi-pencil text-white"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#excluirModal"
                                            onclick="setExcluirId(<?php echo $estacionamento->getId(); ?>)">
                                        <i class="bi bi-trash text-white"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhum estacionamento cadastrado.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'modals.php'; ?>

<script>
    function preencherFormulario(id, veiculoId, local, dataHora, duracao) {
        document.getElementById('editarId').value = id;
        document.getElementById('editarVeiculo').value = veiculoId;
        document.getElementById('editarLocal').value = local;
        document.getElementById('editarDataHora').value = dataHora;
        document.getElementById('editarDuracao').value = duracao;
    }

    function setExcluirId(id) {
        document.getElementById('excluirId').value = id;
    }
</script>

<?php require_once 'footer.php'; ?>