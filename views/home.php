<?php
session_start();
/*if (!isset($_SESSION['usuario_nome'])) {
    header('Location: login.php');
    exit;
}*/
$title = 'Home';
require_once 'header.php';
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
                    <a href="cadastroVeiculo.php" class="btn btn btn-success w-100 mb-2">Veículos</a>
                    <a href="cadastroEstacionamento.php" class="btn btn-primary w-100 mb-2">Estacionar</a>
                    <a href="cadastroUsuario.php" class="btn btn-outline-dark w-100 mb-2">Cadastrar Usuário</a>
                    <a href="login.php" class="btn btn-danger w-100">Sair</a>
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
                <?php if (isset($estacionamentos) && is_array($estacionamentos)): ?>
                    <?php foreach ($estacionamentos as $estacionamento): ?>
                        <tr>
                            <td><?php echo $estacionamento->getId(); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento->getVeiculo()); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento->getLocal()); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($estacionamento->getDataHora())); ?></td>
                            <td><?php echo htmlspecialchars($estacionamento->getDuracao()); ?></td>
                            <td><?php echo $estacionamento->calcularEstacionadoAte(); ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal" 
                                        onclick="preencherFormulario(<?php echo $estacionamento->getId(); ?>, '<?php echo htmlspecialchars($estacionamento->getVeiculo()); ?>', '<?php echo htmlspecialchars($estacionamento->getLocal()); ?>', '<?php echo $estacionamento->getDataHora(); ?>', '<?php echo $estacionamento->getDuracao(); ?>')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#excluirModal" 
                                        onclick="setExcluirId(<?php echo $estacionamento->getId(); ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhum estacionamento cadastrado.</td>
                    </tr>
                <?php endif; ?>
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