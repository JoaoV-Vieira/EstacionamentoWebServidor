<?php
error_reporting(E_ALL & ~E_WARNING);
$title = 'Cadastro de Usuário';
require_once 'header.php';
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <?php require_once 'sidebarUsuario.php'; ?>
        </div>
        <div class="col-md-9">
            <h2>Cadastro de Usuário</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" required>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="administrador" name="administrador">
                        <label class="form-check-label" for="administrador">Administrador</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-success">Cadastrar</button>
                <a href="/EstacionamentoWebServidor/home" class="btn btn-outline-secondary">Voltar</a>
            </form>
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

<?php if (!empty($modalMensagem)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = new bootstrap.Modal(document.getElementById('cadastroUsuarioModal'));
    modal.show();
});
</script>
<?php endif; ?>

<?php require_once 'footer.php'; ?>