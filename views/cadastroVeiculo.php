<?php
require_once __DIR__ . '/../services/FipeService.php';
$title = 'Cadastro de Veículo';
require_once 'header.php';

$fipe = new FipeService();
$tipos = $fipe->getTipos();
?>

<div class="container-cadastro">
    <h2>Cadastro de Veículo</h2>
    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group mb-3">
            <label for="tipo">Tipo de veículo</label>
            <select class="form-control" id="tipo" name="tipo" required>
                <option value="">Selecione um tipo...</option>
                <?php foreach ($tipos as $tipoKey => $tipoLabel): ?>
                    <option value="<?php echo htmlspecialchars($tipoKey); ?>"><?php echo htmlspecialchars($tipoLabel); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="montadora">Montadora</label>
            <select class="form-control" id="montadora" name="montadora" required>
                <option value="">Selecione uma montadora...</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="modelo" class="form-label">Modelo:</label>
            <select class="form-control" id="modelo" name="modelo" required>
                <option value="">Selecione um modelo...</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="placa" class="form-label">Placa:</label>
            <input type="text" name="placa" id="placa" class="form-control" placeholder="ABC-1234" required>
        </div>
        <button type="submit" class="btn btn-outline-success">Cadastrar</button>
        <a href="home.php" class="btn btn-outline-secondary">Voltar</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const montadoraSelect = document.getElementById('montadora');
    const modeloSelect = document.getElementById('modelo');

    tipoSelect.addEventListener('change', function() {
        montadoraSelect.innerHTML = '<option value="">Selecione uma montadora...</option>';
        modeloSelect.innerHTML = '<option value="">Selecione um modelo...</option>';
        const tipo = tipoSelect.value;
        if (tipo) {
            fetch('/EstacionamentoWebServidor/ajax/ajax_marcas.php?tipo=' + tipo)
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(marca) {
                        const opt = document.createElement('option');
                        opt.value = marca.codigo;
                        opt.textContent = marca.nome;
                        montadoraSelect.appendChild(opt);
                    });
                });
        }
    });

    montadoraSelect.addEventListener('change', function() {
        modeloSelect.innerHTML = '<option value="">Selecione um modelo...</option>';
        const tipo = tipoSelect.value;
        const marca = montadoraSelect.value;
        if (tipo && marca) {
            fetch('/EstacionamentoWebServidor/ajax/ajax_modelos.php?tipo=' + tipo + '&marca=' + marca)
                .then(response => response.json())
                .then(data => {
                    if (data.modelos) {
                        data.modelos.forEach(function(modelo) {
                            const opt = document.createElement('option');
                            opt.value = modelo.codigo;
                            opt.textContent = modelo.nome;
                            modeloSelect.appendChild(opt);
                        });
                    }
                });
        }
    });
});
</script>
<?php require_once 'footer.php'; ?>