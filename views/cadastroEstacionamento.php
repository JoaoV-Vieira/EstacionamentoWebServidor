<?php
session_start();
$title = 'Cadastro de Estacionamento';
require_once 'header.php';

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $veiculo = htmlspecialchars($_POST['veiculo'] ?? '');
    $local = htmlspecialchars(trim($_POST['local'] ?? ''));
    $dataHora = htmlspecialchars($_POST['dataHora'] ?? '');

    if (empty($veiculo) || empty($local) || empty($dataHora)) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
       $dataHoraAtual = date('Y-m-d\TH:i');
        if ($dataHora <= $dataHoraAtual) {
            $erro = "Não é possível estacionar em datas ou horas passadas.";
        } else {
            $mensagem = "Estacionamento cadastrado com sucesso!";
        }
    }
}

$veiculos = [
    ['id' => 1, 'descricao' => 'Moto - ABC-1234'],
    ['id' => 2, 'descricao' => 'Carro - DEF-5678'],
    ['id' => 3, 'descricao' => 'Caminhão - GHI-9012']
];

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
        <button type="submit" class="btn btn-outline-success">Cadastrar</button>
    </form>
</div>
<?php require_once 'footer.php'; ?>