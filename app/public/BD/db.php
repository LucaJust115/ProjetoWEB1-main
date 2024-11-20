<?php
$host = 'localhost';
$db = 'api_db';
$user = 'root';
$pass = 'unigran';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo curl_version()['version'];
    var_dump('conexao bem suceddida');
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}