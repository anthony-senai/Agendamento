<?php
    
    $host = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'barbearia';
    $porta = 3306;

$conexao = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conexao->connect_error) {
    die('Erro na conexão: ' . $conexao->connect_error);
}

$conexao->set_charset('utf8mb4');
