<?php

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
                    <a href="/EstacionamentoWebServidor/home" class="btn btn-outline-success w-100 mb-2">Home</a>
                    <div class="dropdown w-100 mb-2">
                        <button class="btn btn-outline-success dropdown-toggle w-100" type="button" id="dropdownVeiculos" data-bs-toggle="dropdown" aria-expanded="false">
                            Veículos
                        </button>
                        <ul class="dropdown-menu w-100 custom-dropdown-menu" aria-labelledby="dropdownVeiculos">
                            <li><a class="dropdown-item" href="/EstacionamentoWebServidor/cadastroVeiculo">Cadastrar Veículo</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/EstacionamentoWebServidor/veiculosCadastrados">Meus Veículos</a></li>
                        </ul>
                    </div>
                    <a href="/EstacionamentoWebServidor/cadastroEstacionamento" class="btn btn-outline-success w-100 mb-2">Estacionar</a>
                    <?php if (isset($_SESSION['usuario_administrador']) && $_SESSION['usuario_administrador'] === 'S'): ?>
                        <a href="/EstacionamentoWebServidor/cadastroUsuario" class="btn btn-outline-dark w-100 mb-2">Cadastrar Usuário</a>
                    <?php endif; ?>
                    <a href="/EstacionamentoWebServidor/logout" class="btn btn-danger w-100">Sair</a>
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
                                        onclick="preencherFormulario(
                                            <?php echo $estacionamento->getId(); ?>,
                                            <?php echo $estacionamento->getVeiculoId(); ?>,
                                            '<?php echo htmlspecialchars($estacionamento->getLocal()); ?>',
                                            '<?php echo $estacionamento->getDataHora(); ?>',
                                            '<?php echo $estacionamento->getDuracao(); ?>'
                                        )">
                                    <i class="bi bi-pencil text-white"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#excluirModal"
                                        onclick="setExcluirId(<?php echo $estacionamento->getId(); ?>)">
                                    <i class="bi bi-trash text-white"></i>
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
    function preencherFormulario(id, veiculoId, local, dataHora, duracao) {
        document.getElementById('editarId').value = id;
        document.getElementById('editarVeiculo').value = veiculoId;
        document.getElementById('editarLocal').value = local;
        document.getElementById('editarDataHora').value = dataHora;
        document.getElementById('editarDuracao').value = duracao;
    }

    function setExcluirId(id) {
        document.getElementById('excluirId').value = id;
    }
</script>

<?php require_once 'footer.php'; ?>