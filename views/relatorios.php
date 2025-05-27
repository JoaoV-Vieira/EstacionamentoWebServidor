<?php

error_reporting(E_ALL & ~E_WARNING);
$modalMensagem = $_SESSION['modalMensagem'] ?? '';
$modalTipo = $_SESSION['modalTipo'] ?? '';
unset($_SESSION['modalMensagem'], $_SESSION['modalTipo']);
?>

<?php
$title = 'Relatórios';
require_once 'header.php';


$tipoRelatorioSelecionado = $tipoRelatorioSelecionado ?? 'estacionamentos';
$dadosRelatorio = $dadosRelatorio ?? [];
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <?php require_once 'sidebarUsuario.php'; ?>
        </div>
        <div class="col-md-2 d-flex flex-column align-items-center">
            <form method="get" class="w-100">
                <div class="d-grid gap-3">
                    <button type="submit" name="tipo" value="estacionamentos" class="btn btn-lg btn-outline-success<?php echo $tipoRelatorioSelecionado === 'estacionamentos' ? ' active' : ''; ?>">
                        Estacionamentos cadastrados
                        <div class="fw-bold fs-4 mt-2"><?php echo $totalEstacionamentos; ?></div>
                    </button>
                    <button type="submit" name="tipo" value="veiculos" class="btn btn-lg btn-outline-success<?php echo $tipoRelatorioSelecionado === 'veiculos' ? ' active' : ''; ?>">
                        Veículos cadastrados
                        <div class="fw-bold fs-4 mt-2"><?php echo $totalVeiculos; ?></div>
                    </button>
                    <button type="submit" name="tipo" value="usuarios" class="btn btn-lg btn-outline-success<?php echo $tipoRelatorioSelecionado === 'usuarios' ? ' active' : ''; ?>">
                        Usuários cadastrados
                        <div class="fw-bold fs-4 mt-2"><?php echo $totalUsuarios; ?></div>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <?php if (!empty($modalMensagem)): ?>
                <div class="alert alert-<?php echo $modalTipo === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($modalMensagem); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <?php
                    if ($tipoRelatorioSelecionado === 'estacionamentos') echo 'Estacionamentos cadastrados';
                    elseif ($tipoRelatorioSelecionado === 'veiculos') echo 'Veículos cadastrados';
                    elseif ($tipoRelatorioSelecionado === 'usuarios') echo 'Usuários cadastrados';
                    ?>
                </h5>
                <a href="/EstacionamentoWebServidor/exportarExcel.php?tipo=<?php echo $tipoRelatorioSelecionado; ?>" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Exportar
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <?php if ($tipoRelatorioSelecionado === 'estacionamentos'): ?>
                                <th>#</th><th>Veículo</th><th>Local</th><th>Data e Hora</th><th>Duração</th><th>Usuário</th>
                            <?php elseif ($tipoRelatorioSelecionado === 'veiculos'): ?>
                                <th>#</th><th>Tipo</th><th>Placa</th><th>Modelo</th><th>Usuário</th>
                            <?php elseif ($tipoRelatorioSelecionado === 'usuarios'): ?>
                                <th>#</th><th>Nome</th><th>Email</th><th>Administrador</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dadosRelatorio)): ?>
                            <tr><td colspan="10" class="text-center">Nenhum registro encontrado.</td></tr>
                        <?php else: ?>
                            <?php foreach ($dadosRelatorio as $item): ?>
                                <tr>
                                    <?php if ($tipoRelatorioSelecionado === 'estacionamentos'): ?>
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo htmlspecialchars($item['veiculo']); ?></td>
                                        <td><?php echo htmlspecialchars($item['local']); ?></td>
                                        <td><?php echo htmlspecialchars($item['data_hora']); ?></td>
                                        <td><?php echo htmlspecialchars($item['duracao']); ?></td>
                                        <td><?php echo htmlspecialchars($item['usuario']); ?></td>
                                    <?php elseif ($tipoRelatorioSelecionado === 'veiculos'): ?>
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo htmlspecialchars($item['tipo']); ?></td>
                                        <td><?php echo htmlspecialchars($item['placa']); ?></td>
                                        <td><?php echo htmlspecialchars($item['modelo']); ?></td>
                                        <td><?php echo htmlspecialchars($item['usuario']); ?></td>
                                    <?php elseif ($tipoRelatorioSelecionado === 'usuarios'): ?>
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                        <td><?php echo htmlspecialchars($item['email']); ?></td>
                                        <td>
                                            <?php echo $item['administrador'] === 'S' ? 'Sim' : 'Não'; ?>
                                            <div class="d-flex gap-1 mt-1">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                                                    onclick="preencherModalEditarUsuario(
                                                        <?php echo $item['id']; ?>,
                                                        '<?php echo htmlspecialchars($item['nome'], ENT_QUOTES); ?>',
                                                        '<?php echo htmlspecialchars($item['email'], ENT_QUOTES); ?>',
                                                        '<?php echo $item['administrador']; ?>'
                                                    )">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#excluirUsuarioModal"
                                                    onclick="setExcluirUsuarioId(<?php echo $item['id']; ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Usuário -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="/EstacionamentoWebServidor/controllers/UsuarioController.php">
      <input type="hidden" name="acao" value="editar">
      <input type="hidden" name="id" id="editarUsuarioId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editarUsuarioNome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="editarUsuarioNome" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="editarUsuarioEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="editarUsuarioEmail" name="email" required>
          </div>
          <div class="mb-3">
            <label for="editarUsuarioAdministrador" class="form-label">Administrador</label>
            <select class="form-select" id="editarUsuarioAdministrador" name="administrador">
              <option value="S">Sim</option>
              <option value="N">Não</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar Alterações</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Excluir Usuário -->
<div class="modal fade" id="excluirUsuarioModal" tabindex="-1" aria-labelledby="excluirUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="/EstacionamentoWebServidor/controllers/UsuarioController.php">
      <input type="hidden" name="acao" value="excluir">
      <input type="hidden" name="id" id="excluirUsuarioId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="excluirUsuarioModalLabel">Excluir Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja excluir este usuário?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Excluir</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function preencherModalEditarUsuario(id, nome, email, administrador) {
    document.getElementById('editarUsuarioId').value = id;
    document.getElementById('editarUsuarioNome').value = nome;
    document.getElementById('editarUsuarioEmail').value = email;
    document.getElementById('editarUsuarioAdministrador').value = administrador;
}
function setExcluirUsuarioId(id) {
    document.getElementById('excluirUsuarioId').value = id;
}
</script>

<?php if (!empty($modalMensagem)): ?>
<script>
    var modal = new bootstrap.Modal(document.getElementById('cadastroUsuarioModal'));
    modal.show();
</script>
<?php endif; ?>

<?php require_once 'footer.php'; ?>