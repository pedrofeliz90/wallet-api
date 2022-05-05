<?php

use Brunosribeiro\WalletApi\Controllers\BalanceController;
use Brunosribeiro\WalletApi\Controllers\TransactionController;
use Brunosribeiro\WalletApi\Controllers\UserController;
use Brunosribeiro\WalletApi\Controllers\ExtractController;
use Brunosribeiro\WalletApi\Controllers\CaixaController;

include "../bootstrap.php";

if($_SERVER["REQUEST_METHOD"] == "POST") { 
   $new = $_POST['new'];
   $funcao = $_POST['funcao'];

}elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
   $new = $_GET['new'];
   $funcao = $_GET['funcao'];

}


if ($new == "BalanceController") {

   $controller = new BalanceController();
   $result = $controller->$funcao();
   echo $result;

}elseif ($new == "TransactionController") {

   $controller = new TransactionController();
   $result = $controller->$funcao();
   echo $result;

}elseif ($new == "UserController") {

   $controller = new UserController();
   $result = $controller->$funcao();
   echo $result;

}elseif ($new == "ExtractController") {

   $data = $_REQUEST;
   $controller = new ExtractController();
   $result = $controller->$funcao($data);
   echo $result;

}elseif ($new == "CaixaController") {

   $controller = new CaixaController();
   $result = $controller->$funcao();
   echo $result;

}


?>