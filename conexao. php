<?php
// conexao.php

$host = 'localhost'; // Host do servidor MySQL
$user = 'u220090763_controleuser'; // Usuário do MySQL
$password = 'Lpp#@300712'; // Senha do MySQL
$dbname = 'u220090763_controleMT'; // Nome do banco de dados

try {
    // Use as mesmas variáveis que você definiu acima:
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Definir o modo de erro do PDO para exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
