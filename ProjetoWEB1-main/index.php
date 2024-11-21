<?php
require_once 'Router.php';
require_once 'app/controllers/AeronaveController.php';
require_once 'app/controllers/OrdemServicoController.php';
require_once 'app/db.php'; 

$pdo = new PDO('mysql:host=localhost;dbname=api_db', 'root', 'unigran');

$router = new Router();

$aeronaveController = new AeronaveController($pdo);
$ordemServicoController = new OrdemServicoController($pdo);

// Adicionar rotas para Aeronaves
$router->add('GET', '/aeronaves', [$aeronaveController, 'index']); // Verifique se o método está correto
$router->add('POST', '/aeronaves', [$aeronaveController, 'store']);
$router->add('DELETE', '/aeronaves/{id}', [AeronaveController::class, 'destroy']);

// Adicionar rotas para Ordens de Serviço
$router->add('POST', '/api/ordemServico/store', [$ordemServicoController, 'store']);
$router->add('GET', '/api/ordemServico', [$ordemServicoController, 'index']);
$router->add('DELETE', '/ordens-servico/{id}', ['OrdemServicoController', 'delete']);




$router->dispatch($_SERVER['REQUEST_URI']);
