<?php
$senha = '123456789';
$hash = password_hash($senha, PASSWORD_DEFAULT);

if (password_verify('minhaSenha123', $hash)) {
    echo $hash;
} else {
    echo $hash;
}


