<?php
$senha = 'minhaSenha123';
$hash = password_hash($senha, PASSWORD_DEFAULT);

if (password_verify('minhaSenha123', $hash)) {
    echo "Senha válida!";
} else {
    echo "Senha inválida!";
}