<?php
$title = 'Meus Veículos';
require_once 'header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-DoygJJllma3dWNZRG4mMbaaoTGCjRwq5GQ&s" 
                     class="card-img-top" 
                     alt="Foto do Usuário" 
                     style="width: 75px; height: 75px; object-fit: cover; margin: 0 auto; margin-top: 10%;">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário'); ?></h5>
                    <p class="card-text">Bem-vindo!</p>
                    <div class="dropdown w-100 mb-2">
                        <button class="btn btn-success dropdown-toggle w-100" type="button" id="dropdownVeiculos" data-bs-toggle="dropdown" aria-expanded="false">
                            Veículos
                        </button>
                        <ul class="dropdown-menu w-100 custom-dropdown-menu" aria-labelledby="dropdownVeiculos">
                            <li><a class="dropdown-item" href="/EstacionamentoWebServidor/cadastroVeiculo">Cadastrar Veículo</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/EstacionamentoWebServidor/veiculosCadastrados">Meus Veículos</a></li>
                        </ul>
                    </div>
                    <a href="/EstacionamentoWebServidor/cadastroEstacionamento" class="btn btn-primary w-100 mb-2">Estacionar</a>
                    <?php if (isset($_SESSION['usuario_administrador']) && $_SESSION['usuario_administrador'] === 'S'): ?>
                        <a href="/EstacionamentoWebServidor/cadastroUsuario" class="btn btn-outline-dark w-100 mb-2">Cadastrar Usuário</a>
                    <?php endif; ?>
                    <a href="/EstacionamentoWebServidor/logout" class="btn btn-danger w-100">Sair</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h3>Veículos Cadastrados</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Placa</th>
                        <th>Modelo</th>
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
                                <!-- Botões de editar/excluir, com modais ou links conforme seu padrão -->
                                <button class="btn btn-sm btn-warning" onclick="abrirEditarVeiculo(<?php echo $veiculo['id']; ?>)">Editar</button>
                                <button class="btn btn-sm btn-danger" onclick="abrirExcluirVeiculo(<?php echo $veiculo['id']; ?>)">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum veículo cadastrado.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>