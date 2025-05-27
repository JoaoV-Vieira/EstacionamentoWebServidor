<?php

$title = 'Home';
require_once 'header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <?php require_once 'sidebarUsuario.php'; ?>
        </div>
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

<!-- Modal de Edição do Estacionamento -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Estacionamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarEstacionamento" method="POST" action="EstacionamentoController.php?acao=editar" autocomplete="off">
                    <input type="hidden" name="id" id="editarId">
                    <div class="form-group mb-3">
                        <label for="editarVeiculo">Veículo</label>
                        <select class="form-control" name="veiculo" id="editarVeiculo" required>
                            <option value="">Selecione um veículo...</option>
                            <?php foreach ($veiculos as $veiculo): ?>
                                <option value="<?php echo $veiculo['id']; ?>"><?php echo htmlspecialchars($veiculo['descricao']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editarLocal">Local</label>
                        <input type="text" name="local" id="editarLocal" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="editarDataHora">Data e Hora</label>
                        <input type="datetime-local" name="dataHora" id="editarDataHora" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label>Duração do Estacionamento</label>
                        <div class="btn-group d-flex" role="group">
                            <input type="radio" class="btn-check" name="duracao" id="editarDuracao30" value="30min" required>
                            <label class="btn btn-outline-success flex-fill" for="editarDuracao30">30min</label>

                            <input type="radio" class="btn-check" name="duracao" id="editarDuracao1h" value="1hr" required>
                            <label class="btn btn-outline-success flex-fill" for="editarDuracao1h">1hr</label>

                            <input type="radio" class="btn-check" name="duracao" id="editarDuracao1h30" value="1h30min" required>
                            <label class="btn btn-outline-success flex-fill" for="editarDuracao1h30">1h30min</label>

                            <input type="radio" class="btn-check" name="duracao" id="editarDuracao2h" value="2hr" required>
                            <label class="btn btn-outline-success flex-fill" for="editarDuracao2h">2hr</label>

                            <input type="radio" class="btn-check" name="duracao" id="editarDuracao2h30" value="2h30min" required>
                            <label class="btn btn-outline-success flex-fill" for="editarDuracao2h30">2h30min</label>

                            <input type="radio" class="btn-check" name="duracao" id="editarDuracao3h" value="3hr" required>
                            <label class="btn btn-outline-success flex-fill" for="editarDuracao3h">3hr</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" aria-label="Salvar alterações"
                        onclick="abrirConfirmacaoEdicao()">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão do Estacionamento -->
<div class="modal fade" id="excluirModal" tabindex="-1" aria-labelledby="excluirModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/EstacionamentoWebServidor/controllers/EstacionamentoController.php?acao=excluir">
      <input type="hidden" name="id" id="excluirId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="excluirModalLabel">Excluir Estacionamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja excluir este estacionamento?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Excluir</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal de Confirmação de Edição -->
<div class="modal fade" id="confirmarEdicaoModal" tabindex="-1" aria-labelledby="confirmarEdicaoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarEdicaoModalLabel">Confirmar Alteração</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja salvar as alterações deste estacionamento?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="confirmarEdicao()">Sim, salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
function preencherFormulario(id, veiculoId, local, dataHora, duracao) {
    document.getElementById('editarId').value = id;
    document.getElementById('editarVeiculo').value = veiculoId;
    document.getElementById('editarLocal').value = local;
    document.getElementById('editarDataHora').value = dataHora;

    document.querySelectorAll('input[name="duracao"]').forEach(r => r.checked = false);
    if (duracao) {
        let radio = document.querySelector('input[name="duracao"][value="' + duracao + '"]');
        if (radio) radio.checked = true;
    }
}

function setExcluirId(id) {
    document.getElementById('excluirId').value = id;
}

function abrirConfirmacaoEdicao() {
    var modal = new bootstrap.Modal(document.getElementById('confirmarEdicaoModal'));
    modal.show();
}

function confirmarEdicao() {
    document.getElementById('formEditarEstacionamento').submit();
}
</script>

<?php require_once 'footer.php'; ?>