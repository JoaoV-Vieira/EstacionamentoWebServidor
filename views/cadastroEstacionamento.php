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
                    <option value="<?php echo $veiculo['id']; ?>"><?php echo htmlspecialchars($veiculo['descricao']); ?></option>
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
            <span id="estacionadoAte" class="form-control" style="display: block; background-color: #e9ecef;">
                <?php
                echo isset($estacionadoAte) ? htmlspecialchars($estacionadoAte) : 'Será calculado automaticamente';
                ?>
            </span>
        </div>
        <button type="submit" class="btn btn-outline-success">Estacionar</button>
        <a href="home.php" class="btn btn-outline-secondary">Voltar</a>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataHoraInput = document.getElementById('dataHora');
    const duracaoRadios = document.querySelectorAll('input[name="duracao"]');
    const estacionadoAteSpan = document.getElementById('estacionadoAte');

    function calcularEstacionadoAte() {
        if (!dataHoraInput) return;
        const dataHoraSelecionada = new Date(dataHoraInput.value);
        if (isNaN(dataHoraSelecionada.getTime())) {
            estacionadoAteSpan.textContent = 'Será calculado automaticamente';
            return;
        }

        let minutosAdicionais = 0;
        duracaoRadios.forEach(radio => {
            if (radio.checked) {
                switch (radio.value) {
                    case '30min': minutosAdicionais = 30; break;
                    case '1hr': minutosAdicionais = 60; break;
                    case '1h30min': minutosAdicionais = 90; break;
                    case '2hr': minutosAdicionais = 120; break;
                    case '2h30min': minutosAdicionais = 150; break;
                    case '3hr': minutosAdicionais = 180; break;
                }
            }
        });

        if (minutosAdicionais > 0) {
            const dataHoraFinal = new Date(dataHoraSelecionada.getTime() + minutosAdicionais * 60000);
            const dia = String(dataHoraFinal.getDate()).padStart(2, '0');
            const mes = String(dataHoraFinal.getMonth() + 1).padStart(2, '0');
            const ano = dataHoraFinal.getFullYear();
            const hora = String(dataHoraFinal.getHours()).padStart(2, '0');
            const min = String(dataHoraFinal.getMinutes()).padStart(2, '0');
            estacionadoAteSpan.textContent = `${dia}/${mes}/${ano} ${hora}:${min}`;
        } else {
            estacionadoAteSpan.textContent = 'Será calculado automaticamente';
        }
    }

    if (dataHoraInput) dataHoraInput.addEventListener('input', calcularEstacionadoAte);
    duracaoRadios.forEach(radio => radio.addEventListener('change', calcularEstacionadoAte));
});
</script>
<?php require_once 'footer.php'; ?>