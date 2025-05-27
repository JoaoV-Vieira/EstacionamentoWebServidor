<?php
error_reporting(E_ALL & ~E_WARNING);
session_start();
$title = 'Meus Veículos';
require_once 'header.php';

$fipe = new FipeService();
$tipos = $fipe->getTipos();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <?php require_once 'sidebarUsuario.php'; ?>
        </div>
        <div class="col-md-9">
            <?php
            if (!empty($_SESSION['mensagem'])) {
                echo '<div class="alert alert-success">'.htmlspecialchars($_SESSION['mensagem']).'</div>';
                unset($_SESSION['mensagem']);
            }
            if (!empty($_SESSION['erro'])) {
                echo '<div class="alert alert-danger">'.htmlspecialchars($_SESSION['erro']).'</div>';
                unset($_SESSION['erro']);
            }
            ?>
            <h3 class="d-flex justify-content-between align-items-center">
                Meus Veículos
                <a href="/EstacionamentoWebServidor/exportarExcel.php?tipo=veiculos" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Exportar
                </a>
            </h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Montadora</th>
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
                                <?php
                                    echo isset($veiculo['montadora']) && $veiculo['montadora'] !== '' 
                                        ? htmlspecialchars($veiculo['montadora']) 
                                        : (isset($veiculo['montadora_nome']) ? htmlspecialchars($veiculo['montadora_nome']) : '');
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="abrirEditarVeiculo(
                                    <?php echo $veiculo['id']; ?>,
                                    '<?php echo htmlspecialchars($veiculo['tipo'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($veiculo['placa'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($veiculo['modelo'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($veiculo['montadora'] ?? '', ENT_QUOTES); ?>'
                                )">
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
                        <td colspan="6" class="text-center">Nenhum veículo cadastrado.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
 
<!-- Modal Editar Veículo -->
<div class="modal fade" id="editarVeiculoModal" tabindex="-1" aria-labelledby="editarVeiculoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarVeiculo" method="POST" action="/EstacionamentoWebServidor/controllers/VeiculoController.php">
      <input type="hidden" name="acao" value="editar">
      <input type="hidden" name="id" id="editarVeiculoId">
      <input type="hidden" name="montadora_nome" id="editarMontadoraNome">
      <input type="hidden" name="modelo_nome" id="editarModeloNome">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarVeiculoModalLabel">Editar Veículo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editarTipo" class="form-label">Tipo de veículo</label>
            <select class="form-control" id="editarTipo" name="tipo" required>
              <option value="">Selecione um tipo...</option>
              <?php foreach ($tipos as $tipoKey => $tipoLabel): ?>
                <option value="<?php echo htmlspecialchars($tipoKey); ?>"><?php echo htmlspecialchars($tipoLabel); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="editarMontadora" class="form-label">Montadora</label>
            <select class="form-control" id="editarMontadora" name="montadora" required>
              <option value="">Selecione uma montadora...</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editarModelo" class="form-label">Modelo</label>
            <select class="form-control" id="editarModelo" name="modelo" required>
              <option value="">Selecione um modelo...</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editarPlaca" class="form-label">Placa</label>
            <input type="text" class="form-control" id="editarPlaca" name="placa" required maxlength="8">
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

<!-- Modal Excluir Veículo -->
<div class="modal fade" id="excluirVeiculoModal" tabindex="-1" aria-labelledby="excluirVeiculoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/EstacionamentoWebServidor/controllers/VeiculoController.php">
      <input type="hidden" name="acao" value="excluir">
      <input type="hidden" name="id" id="excluirVeiculoId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="excluirVeiculoModalLabel">Excluir Veículo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja excluir este veículo?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Excluir</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Ajuste: Modal de edição será aberto imediatamente, mas os selects só serão preenchidos após as buscas -->
<script>
let editarVeiculoUltimoTipo = '';
let editarVeiculoUltimaMontadora = '';
let editarVeiculoUltimoModelo = '';

function abrirEditarVeiculo(id, tipo, placa, modelo, montadora) {
    document.getElementById('editarVeiculoId').value = id;
    document.getElementById('editarPlaca').value = placa;
    editarVeiculoUltimoTipo = tipo;
    editarVeiculoUltimaMontadora = montadora;
    editarVeiculoUltimoModelo = modelo;

    // Preencher campos ocultos
    document.getElementById('editarMontadoraNome').value = montadora;
    document.getElementById('editarModeloNome').value = modelo;

    var modal = new bootstrap.Modal(document.getElementById('editarVeiculoModal'));
    modal.show();

    const tipoSelect = document.getElementById('editarTipo');
    tipoSelect.value = tipo;
    tipoSelect.dispatchEvent(new Event('change'));
}

document.getElementById('editarTipo').addEventListener('change', function() {
    const tipo = this.value;
    const montadoraSelect = document.getElementById('editarMontadora');
    const modeloSelect = document.getElementById('editarModelo');
    montadoraSelect.innerHTML = '<option value="">Selecione uma montadora...</option>';
    modeloSelect.innerHTML = '<option value="">Selecione um modelo...</option>';
    if (tipo) {
        fetch('/EstacionamentoWebServidor/ajax/ajax_marcas.php?tipo=' + tipo)
            .then(response => response.json())
            .then(data => {
                data.forEach(function(marca) {
                    const opt = document.createElement('option');
                    opt.value = marca.codigo;
                    opt.textContent = marca.nome;
                    opt.setAttribute('data-nome', marca.nome);
                    montadoraSelect.appendChild(opt);
                });
                if (editarVeiculoUltimaMontadora) {
                    for (let i = 0; i < montadoraSelect.options.length; i++) {
                        if (montadoraSelect.options[i].textContent === editarVeiculoUltimaMontadora) {
                            montadoraSelect.selectedIndex = i;
                            document.getElementById('editarMontadoraNome').value = editarVeiculoUltimaMontadora;
                            montadoraSelect.dispatchEvent(new Event('change'));
                            break;
                        }
                    }
                }
            });
    }
});

document.getElementById('editarMontadora').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById('editarMontadoraNome').value = selectedOption ? selectedOption.textContent : '';
    const tipo = document.getElementById('editarTipo').value;
    const marcaCodigo = this.value;
    const modeloSelect = document.getElementById('editarModelo');
    modeloSelect.innerHTML = '<option value="">Selecione um modelo...</option>';
    if (tipo && marcaCodigo) {
        fetch('/EstacionamentoWebServidor/ajax/ajax_modelos.php?tipo=' + tipo + '&marca=' + marcaCodigo)
            .then(response => response.json())
            .then(data => {
                if (data.modelos) {
                    data.modelos.forEach(function(mod) {
                        const opt = document.createElement('option');
                        opt.value = mod.codigo;
                        opt.textContent = mod.nome;
                        opt.setAttribute('data-nome', mod.nome);
                        modeloSelect.appendChild(opt);
                    });
                    if (editarVeiculoUltimoModelo) {
                        for (let i = 0; i < modeloSelect.options.length; i++) {
                            if (modeloSelect.options[i].textContent === editarVeiculoUltimoModelo) {
                                modeloSelect.selectedIndex = i;
                                document.getElementById('editarModeloNome').value = editarVeiculoUltimoModelo;
                                editarVeiculoUltimoModelo = '';
                                break;
                            }
                        }
                    }
                }
            });
    }
});

document.getElementById('editarModelo').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    document.getElementById('editarModeloNome').value = selectedOption ? selectedOption.textContent : '';
});

function abrirExcluirVeiculo(id) {
    document.getElementById('excluirVeiculoId').value = id;
    var modal = new bootstrap.Modal(document.getElementById('excluirVeiculoModal'));
    modal.show();
}

document.getElementById('editarPlaca').addEventListener('input', function() {
    let v = this.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
    if (v.length > 3) v = v.slice(0,3) + '-' + v.slice(3,7);
    this.value = v;
});
</script>

<?php require_once 'footer.php'; ?>