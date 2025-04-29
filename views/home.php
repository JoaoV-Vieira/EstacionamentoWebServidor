<?php
session_start();
/*if (!isset($_SESSION['usuario_nome'])) {
    header('Location: login.php');
    exit;
}*/
$title = 'Home';
require_once 'header.php';

// Dados fictícios de estacionamentos
$estacionamentos = [
    ['id' => 1, 'veiculo' => 'Carro - ABC-1234', 'local' => 'Shopping Center', 'dataHora' => '2025-04-29T14:00', 'duracao' => '2hr'],
    ['id' => 2, 'veiculo' => 'Moto - DEF-5678', 'local' => 'Supermercado', 'dataHora' => '2025-04-29T15:30', 'duracao' => '1h30min'],
    ['id' => 3, 'veiculo' => 'Caminhão - GHI-9012', 'local' => 'Centro de Distribuição', 'dataHora' => '2025-04-29T16:00', 'duracao' => '3hr'],
    ['id' => 4, 'veiculo' => 'Carro - JKL-3456', 'local' => 'Estádio', 'dataHora' => '2025-04-29T17:00', 'duracao' => '2h30min'],
    ['id' => 5, 'veiculo' => 'Moto - MNO-7890', 'local' => 'Parque', 'dataHora' => '2025-04-29T18:00', 'duracao' => '1hr'],
    ['id' => 6, 'veiculo' => 'Carro - PQR-1234', 'local' => 'Aeroporto', 'dataHora' => '2025-04-29T19:00', 'duracao' => '3hr']
];

// Função para calcular o horário "Estacionado até"
function calcularEstacionadoAte($dataHora, $duracao) {
    $horarioInicial = new DateTime($dataHora);
    $minutosAdicionais = 0;

    // Converte a duração para minutos
    switch ($duracao) {
        case '30min':
            $minutosAdicionais = 30;
            break;
        case '1hr':
            $minutosAdicionais = 60;
            break;
        case '1h30min':
            $minutosAdicionais = 90;
            break;
        case '2hr':
            $minutosAdicionais = 120;
            break;
        case '2h30min':
            $minutosAdicionais = 150;
            break;
        case '3hr':
            $minutosAdicionais = 180;
            break;
    }

    // Adiciona os minutos ao horário inicial
    $horarioInicial->modify("+$minutosAdicionais minutes");
    return $horarioInicial->format('d/m/Y H:i');
}
?>

<div class="container mt-5">
    <div class="row">
        <!-- Coluna da esquerda: Informações do usuário -->
        <div class="col-md-3">
            <div class="card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-DoygJJllma3dWNZRG4mMbaaoTGCjRwq5GQ&s" 
                     class="card-img-top" 
                     alt="Foto do Usuário" 
                     style="width: 75px; height: 75px; object-fit: cover; margin: 0 auto; margin-top: 10%;">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário'); ?></h5>
                    <p class="card-text">Bem-vindo!</p>
                    <a href="cadastroVeiculo.php" class="btn btn-primary w-100 mb-2">Veículos</a>
                    <a href="cadastroEstacionamento.php" class="btn btn-primary w-100 mb-2">Estacionar</a>
                    <a href="logout.php" class="btn btn-danger w-100">Sair</a>
                </div>
            </div>
        </div>

        <!-- Coluna da direita: Lista de estacionamentos -->
        <div class="col-md-9">
            <h3>Estacionamentos Cadastrados</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Veículo</th>
                        <th>Local</th>
                        <th>Data e Hora</th>
                        <th>Duração</th>
                        <th>Estacionado até</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estacionamentos as $estacionamento): ?>
                        <tr>
                            <td><?php echo $estacionamento['id']; ?></td>
                            <td><?php echo htmlspecialchars($estacionamento['veiculo']); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento['local']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($estacionamento['dataHora'])); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento['duracao']); ?></td>
                            <td><?php echo calcularEstacionadoAte($estacionamento['dataHora'], $estacionamento['duracao']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal" 
                                        onclick="preencherFormulario(<?php echo $estacionamento['id']; ?>, '<?php echo htmlspecialchars($estacionamento['veiculo']); ?>', '<?php echo htmlspecialchars($estacionamento['local']); ?>', '<?php echo $estacionamento['dataHora']; ?>', '<?php echo $estacionamento['duracao']; ?>')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#excluirModal" 
                                        onclick="setExcluirId(<?php echo $estacionamento['id']; ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'modals.php'; ?>

<script>
    function preencherFormulario(id, veiculo, local, dataHora, duracao) {
        document.getElementById('editarId').value = id;
        document.getElementById('editarVeiculo').value = veiculo;
        document.getElementById('editarLocal').value = local;
        document.getElementById('editarDataHora').value = dataHora;
        document.getElementById('editarDuracao').value = duracao;
    }

    function setExcluirId(id) {
        document.getElementById('excluirId').value = id;
    }
</script>

<?php require_once 'footer.php'; ?>