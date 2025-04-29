<?php
session_start();
$title = 'Cadastro de Estacionamento';
require_once 'header.php';
?>

<div class="container-cadastro">
    <h2>Cadastro de Estacionamento</h2>
    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group mb-3">
            <label for="veiculo">Veículo</label>
            <select class="form-control" id="veiculo" name="veiculo">
                <option value="">Selecione um veículo...</option>
                <?php foreach ($veiculos as $veiculo): ?>
                    <option value="<?php echo $veiculo['id']; ?>"><?php echo $veiculo['descricao']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="local">Local</label>
            <input type="text" name="local" id="local" class="form-control" placeholder="Digite o local" required>
        </div>
        <div class="form-group mb-3">
            <label for="dataHora">Data e Hora</label>
            <input type="datetime-local" name="dataHora" id="dataHora" class="form-control" required>
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
        <div class="form-group mb-3">
            <label for="estacionadoAte">Estacionado até</label>
            <span id="estacionadoAte" class="form-control" style="display: block; background-color: #e9ecef;">Será calculado automaticamente</span>
        </div>
        <button type="submit" class="btn btn-outline-success">Estacionar</button>
    </form>
</div>
<?php require_once 'footer.php'; ?>