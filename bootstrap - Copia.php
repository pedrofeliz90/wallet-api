<?php

use Brunosribeiro\WalletApi\Controllers\BalanceController;
use Brunosribeiro\WalletApi\Controllers\ExtractController;
use Brunosribeiro\WalletApi\Controllers\TransactionController;
use Brunosribeiro\WalletApi\Controllers\UserController;
use Brunosribeiro\WalletApi\Controllers\CaixaController;
use Brunosribeiro\WalletApi\Router;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Infra\iniciaDB;

require "vendor/autoload.php";

$environment = require '../environment.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__, $environment);
$dotenv->load();

$iniciaDB = require '../src/Infra/DBInit.php';

$conn = new DBConnection(
    $_ENV['DB_HOST'],
    $_ENV['DB_DATABASE'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

$iniciaDB = new iniciaDB($conn);
$iniciaDB->iniciaDB();

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

$router = new Router($method, $path);

$router->get('/', function () {
    return '<form action="/porcaixa" method="post">
 <p>Jogador: <input type="text" name="id"/></p>
 <p>Valor: <input type="text" name="idcaixa" /></p>
 <p><input type="submit" /></p>
</form>';
});

$router->get('/usuarios', function () {
    return header ("location: ../usuarios.php");;    
});

$router->get('/cashgame', function () {
    return header ("location: ../cashgame.php");;    
});

$router->get('/users', function () {
    $userController = new UserController();
    $result = $userController->getAllUsers();
    return $result;
});

$router->get('/caixas', function () {
    $caixaController = new CaixaController();
    $result = $caixaController->MostrarCaixas();
    return $result;
});

$router->get('/transacao', function () {
    $extractController = new ExtractController();
    $result = $extractController->getAllTransaction();
    return $result;
});

$router->get('/abrircaixa', function () {
    $caixaController = new CaixaController();
    $result = $caixaController->abrircaixa();
    return $result;
});

$router->post('/fecharcaixa', function () {
    $params = $_POST;
    $caixaController = new CaixaController();
    $result = $caixaController->fecharcaixa($params);
    return $result;
});

$router->get('/user/{id}', function ($params) {
    $id = $params[1];
    $userController = new UserController();
    $result = $userController->getUserById($id);
    return $result;
});

$router->get('/buscar/{tipo}', function ($params) {
    $tipo = $params[1];
    $userController = new UserController();
    $result = $userController->getUserByTipo($tipo);
    return $result;
});

$router->get('/user/pix/?', function ($params) {
    $pix = $_GET['pix'];
    $userController = new UserController();
    $result = $userController->getUserBypix($pix);
    return $result;
});

$router->get('/user/name/?', function ($params) {
    $name = $_GET['name'];
    $userController = new UserController();
    $result = $userController->getUserByName($name);
    return $result;
});

$router->post('/user', function () {
    $params = $_POST;
    $userController = new UserController();
    $result = $userController->addUser($params);
    return $result;
});

$router->post('/user/{id}', function ($params) {
    $id = $params[1];
    $data = $_POST;
    $userController = new UserController();
    $result = $userController->editUser($id, $data);
    return $result;
});

$router->delete('/user/del/{id}', function ($params) {
    $id = $params[1];
    $userController = new UserController();
    $result = $userController->deleteUser($id);
    return $result;
});

$router->post('/addcredit', function () {
    $data = $_POST;
    $transactionController = new TransactionController();
    $result = $transactionController->addTransactionCredit($data);
    return $result;
});

$router->post('/adddebit', function () {
    $data = $_POST;
    $transactionController = new TransactionController();
    $result = $transactionController->addTransactionDebit($data);
    return $result;
});

$router->post('/addcreditcrupie', function () {
    $data = $_POST;
    $transactionController = new TransactionController();
    $result = $transactionController->addTransactionCrupie($data);
    return $result;
});

$router->get('/balance/{id}', function ($params) {
    $id = $params[1];
    $balanceController = new BalanceController();
    $result = $balanceController->getBalanceByIdAtual($id);
    return $result;
});

$router->get('/porcaixa/?', function ($params) {
    $data = $_GET;
    $extractController = new ExtractController();
    $result = $extractController->getPerCaixa($data);
    return $result;
});

$router->get('/balance', function () {
    $balanceController = new BalanceController();
    $result = $balanceController->getBalanceByIdAll();
    return $result;
});

$router->get('/extractlastdays/?', function ($params) {
    $data = $_GET;
    $extractController = new ExtractController();
    $result = $extractController->getLastDaysById($data);
    return $result;
});

$router->get('/extractperperiod/?', function ($params) {
    $data = $_GET;
    $extractController = new ExtractController();
    $result = $extractController->getPerPeriodById($data);
    return $result;
});

$result = $router->handler();

//if (!$result) {
    //http_response_code(404);
  //  echo 'Rota não encontrada!';
  //  die();
//}

echo $result($router->getParams());
//echo $result();