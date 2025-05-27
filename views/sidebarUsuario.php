<?php
error_reporting(E_ALL & ~E_WARNING);
$paginaAtual = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>
<div class="card">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-DoygJJllma3dWNZRG4mMbaaoTGCjRwq5GQ&s" 
         class="card-img-top" 
         alt="Foto do Usuário" 
         style="width: 75px; height: 75px; object-fit: cover; margin: 0 auto; margin-top: 10%;">
    <div class="card-body text-center">
        <h5 class="card-title"><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário'); ?></h5>
        <p class="card-text">Bem-vindo!</p>
        <a href="/EstacionamentoWebServidor/home"
           class="btn w-100 mb-2<?php echo ($paginaAtual === 'home' || $paginaAtual === '') ? ' btn-success text-white disabled' : ' btn-outline-success'; ?>"
           <?php echo ($paginaAtual === 'home' || $paginaAtual === '') ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
            Home
        </a>
        <div class="dropdown w-100 mb-2">
            <button class="btn btn-outline-success dropdown-toggle w-100" type="button" id="dropdownVeiculos" data-bs-toggle="dropdown" aria-expanded="false">
                Veículos
            </button>
            <ul class="dropdown-menu w-100 custom-dropdown-menu" aria-labelledby="dropdownVeiculos">
                <li>
                    <a class="dropdown-item<?php echo ($paginaAtual === 'cadastroVeiculo') ? ' active bg-success text-white disabled' : ''; ?>"
                       href="/EstacionamentoWebServidor/cadastroVeiculo"
                       <?php echo ($paginaAtual === 'cadastroVeiculo') ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                        Cadastrar Veículo
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item<?php echo ($paginaAtual === 'veiculosCadastrados') ? ' active bg-success text-white disabled' : ''; ?>"
                       href="/EstacionamentoWebServidor/veiculosCadastrados"
                       <?php echo ($paginaAtual === 'veiculosCadastrados') ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                        Meus Veículos
                    </a>
                </li>
            </ul>
        </div>
        <a href="/EstacionamentoWebServidor/cadastroEstacionamento"
           class="btn w-100 mb-2<?php echo ($paginaAtual === 'cadastroEstacionamento') ? ' btn-success text-white disabled' : ' btn-outline-success'; ?>"
           <?php echo ($paginaAtual === 'cadastroEstacionamento') ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
            Estacionar
        </a>
        <?php if (isset($_SESSION['usuario_administrador']) && $_SESSION['usuario_administrador'] === 'S'): ?>
            <a href="/EstacionamentoWebServidor/cadastroUsuario"
               class="btn w-100 mb-2<?php echo ($paginaAtual === 'cadastroUsuario') ? ' btn-dark text-white disabled' : ' btn-outline-dark'; ?>"
               <?php echo ($paginaAtual === 'cadastroUsuario') ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                Cadastrar Usuário
            </a>
            <a href="/EstacionamentoWebServidor/relatorios"
               class="btn w-100 mb-2<?php echo ($paginaAtual === 'relatorios') ? ' btn-dark text-white disabled' : ' btn-outline-dark'; ?>"
               <?php echo ($paginaAtual === 'relatorios') ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                Relatórios
            </a>
        <?php endif; ?>
        <a href="/EstacionamentoWebServidor/logout" class="btn btn-danger w-100">Sair</a>
    </div>
</div>