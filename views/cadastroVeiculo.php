<?php
session_start();
$title = 'Cadastro de Veículo';
require_once 'header.php';
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
            <select class="form-control" id="tipo" name="tipo">
                <option value="">Selecione um tipo...</option>
                <?php foreach ($tipos as $tipo): ?>
                    <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['descricao']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="montadora">Montadora</label>
            <select class="form-control" id="montadora" name="montadora">
                <option value="">Selecione uma montadora...</option>
                <?php foreach ($montadoras as $montadora): ?>
                    <option value="<?php echo $montadora['id']; ?>"><?php echo $montadora['descricao']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="modelo" class="form-label">Modelo:</label>
            <input type="text" name="modelo" id="modelo" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="placa" class="form-label">Placa:</label>
            <input type="text" name="placa" id="placa" class="form-control" placeholder="ABC-1234" required>
        </div>
        <button type="submit" class="btn btn-outline-success">Cadastrar</button>
    </form>
</div>
<?php require_once 'footer.php'; ?>