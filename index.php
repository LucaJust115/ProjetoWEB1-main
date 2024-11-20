<?php

require_once './app/public/controllers/AeronaveController.php';
require_once './app/public/controllers/OrdemServicoController.php';
require_once './Router.php';
require_once './app/public/BD/db.php';

$aeronaveController = new AeronaveController($pdo);
$ordemServicoController = new OrdemServicoController($pdo);

$router->add('GET', '/aeronaves', [$aeronaveController, 'list']);
$router->add('GET', '/aeronaves/{id}', [$aeronaveController, 'getById']);
$router->add('POST', '/aeronaves', [$aeronaveController, 'create']);
$router->add('DELETE', '/aeronaves/{id}', [$aeronaveController, 'delete']);
$router->add('PUT', '/aeronaves/{id}', [$aeronaveController, 'update']);

$router->add('GET', '/ordens-servico', [$ordemServicoController, 'list']);
$router->add('GET', '/ordens-servico/{id}', [$ordemServicoController, 'getById']);
$router->add('POST', '/ordens-servico', [$ordemServicoController, 'create']);
$router->add('DELETE', '/ordens-servico/{id}', [$ordemServicoController, 'delete']);
$router->add('PUT', '/ordens-servico/{id}', [$ordemServicoController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pathItems = explode("/", $requestedPath);
$requestedPath = implode("/", $pathItems);;
$router->dispatch(requestedPath: $requestedPath);
?>
