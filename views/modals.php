
<!-- Modal de Edição do Estacionamento -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Estacionamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="editarEstacionamento.php" autocomplete="off">
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
                    <button type="submit" class="btn btn-primary" aria-label="Salvar alterações">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal de Cadastro de Usuario -->
<div class="modal fade" id="cadastroUsuarioModal" tabindex="-1" aria-labelledby="cadastroUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-<?php echo $modalTipo === 'success' ? 'success' : 'danger'; ?>">
        <h5 class="modal-title text-white" id="cadastroUsuarioModalLabel">
          <?php echo $modalTipo === 'success' ? 'Sucesso' : 'Erro'; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <?php echo htmlspecialchars($modalMensagem); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-<?php echo $modalTipo === 'success' ? 'success' : 'danger'; ?>" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal de Cadastro de Veiculo -->
<div class="modal fade" id="cadastroVeiculoModal" tabindex="-1" aria-labelledby="cadastroVeiculoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-<?php echo $modalTipo === 'success' ? 'success' : 'danger'; ?>">
        <h5 class="modal-title text-white" id="cadastroVeiculoModalLabel">
          <?php echo $modalTipo === 'success' ? 'Sucesso' : 'Erro'; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <?php echo htmlspecialchars($modalMensagem); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-<?php echo $modalTipo === 'success' ? 'success' : 'danger'; ?>" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Cadastro de Estacionamento -->
<div class="modal fade" id="cadastroEstacionamentoModal" tabindex="-1" aria-labelledby="cadastroEstacionamentoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header <?php echo !empty($mensagem) ? 'bg-success' : 'bg-danger'; ?>">
        <h5 class="modal-title text-white" id="cadastroEstacionamentoModalLabel">
          <?php echo !empty($mensagem) ? 'Sucesso' : 'Erro'; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <?php
          if (!empty($mensagem)) {
              echo htmlspecialchars($mensagem);
          } elseif (!empty($erro)) {
              echo htmlspecialchars($erro);
          }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>