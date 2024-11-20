<?php
// Carregar as classes necessárias
require_once 'Router.php';
require_once 'app/controllers/AeronaveController.php';
require_once 'app/controllers/OrdemServicoController.php';
require_once 'app/db.php'; // Assegure-se de que o db.php está correto

// Criar a instância do banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=api_db', 'root', 'unigran');

// Criar instância do Router
$router = new Router();

// Criar instâncias dos controladores
$aeronaveController = new AeronaveController($pdo);
$ordemServicoController = new OrdemServicoController($pdo);

// Adicionar rotas ao roteador
$router->add('GET', '/aeronaves', [$aeronaveController, 'index']); // Verifique se o método está correto
$router->add('POST', '/aeronaves', [$aeronaveController, 'store']);
$router->add('PUT', '/aeronaves/{id}', [$aeronaveController, 'update']);
$router->add('DELETE', '/aeronaves/{id}', [AeronaveController::class, 'destroy']);

// Adicionar rotas para Ordens de Serviço
$router->add('POST', '/api/ordemServico/store', [$ordemServicoController, 'store']);
$router->add('GET', '/api/ordemServico', [$ordemServicoController, 'index']);
// Adicionando rota DELETE para /ordens-servico/{id}
$router->add('DELETE', '/ordens-servico/{id}', ['OrdemServicoController', 'delete']);




// Despachar a requisição
$router->dispatch($_SERVER['REQUEST_URI']);
