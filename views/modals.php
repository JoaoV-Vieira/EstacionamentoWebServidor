<!-- Modal de Confirmação de Exclusão do Estacionamento -->
<div class="modal fade" id="excluirModal" tabindex="-1" aria-labelledby="excluirModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excluirModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir este estacionamento?
            </div>
            <div class="modal-footer">
                <form method="POST" action="excluirEstacionamento.php">
                    <input type="hidden" name="id" id="excluirId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição do Estacionamento -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Estacionamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="editarEstacionamento.php">
                    <input type="hidden" name="id" id="editarId">
                    <div class="form-group mb-3">
                        <label for="editarVeiculo">Veículo</label>
                        <input type="text" name="veiculo" id="editarVeiculo" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editarLocal">Local</label>
                        <input type="text" name="local" id="editarLocal" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editarDataHora">Data e Hora</label>
                        <input type="datetime-local" name="dataHora" id="editarDataHora" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Duração do Estacionamento</label>
                        <div class="btn-group d-flex" role="group">
                            <input type="radio" class="btn-check" name="duracao" id="duracao30" value="30min" required>
                            <label class="btn btn-outline-success flex-fill" for="duracao30">30min</label>

                            <input type="radio" class="btn-check" name="duracao" id="duracao1h" value="1hr" required>
                            <label class="btn btn-outline-success flex-fill" for="duracao1h">1hr</label>

                            <input type="radio" class="btn-check" name="duracao" id="duracao1h30" value="1h30min" required>
                            <label class="btn btn-outline-success flex-fill" for="duracao1h30">1h30min</label>

                            <input type="radio" class="btn-check" name="duracao" id="duracao2h" value="2hr" required>
                            <label class="btn btn-outline-success flex-fill" for="duracao2h">2hr</label>

                            <input type="radio" class="btn-check" name="duracao" id="duracao2h30" value="2h30min" required>
                            <label class="btn btn-outline-success flex-fill" for="duracao2h30">2h30min</label>

                            <input type="radio" class="btn-check" name="duracao" id="duracao3h" value="3hr" required>
                            <label class="btn btn-outline-success flex-fill" for="duracao3h">3hr</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>