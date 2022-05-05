<?php
use Brunosribeiro\WalletApi\Controllers\TransactionController;
use Brunosribeiro\WalletApi\Controllers\BalanceController;
use Brunosribeiro\WalletApi\Controllers\UserController;
use Brunosribeiro\WalletApi\Controllers\ExtractController;
include "index.php";

class Cashgame {

    public function compra($dados) {
        $data = $_POST;
        $transactionController = new TransactionController();
        $result = $transactionController->addTransactionDebit($data);
        $result = json_decode($result, TRUE);
        if (isset($result['success'])) {
          echo $result['success'];
        }elseif (isset($result['error'])){
          echo $result['error'];
        }elseif (isset($result['warning'])){
          echo $result['warning'];
        }
        
    }
    public function pagamento($dados) {
        $data = $_POST;
        $transactionController = new TransactionController();
        $result = $transactionController->addTransactionDebit($data);
        $result = json_decode($result, TRUE);
        if (isset($result['success'])) {
          echo $result['success'];
        }elseif (isset($result['error'])){
          echo $result['error'];
        }elseif (isset($result['warning'])){
          echo $result['warning'];
        }
    }

    public function visualizar($id, $idcaixa) {
        $extractController = new ExtractController();
        $resultExtract = $extractController->getPerCaixa($id, $idcaixa);
        $resultExtract = json_decode($resultExtract, TRUE);
        if (isset($result['success'])) {
          echo $resultExtract['success'];
        }elseif (isset($result['error'])){
          echo $resultExtract['error'];
        }elseif (isset($result['warning'])){
          echo $resultExtract['warning'];
        }
    }

}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['method'])) { // aqui é onde vai decorrer a chamada se houver um *request* POST
    $method = $_POST['method'];
    if(method_exists('Cashgame', $method)) {
        $cashgame = new Cashgame;
        $cashgame->$method($_POST);
    }
    else {
        echo 'Metodo incorreto';
    }
}

$userController = new UserController();
$resultUser = $userController->getAllUsers();
$resultUser = json_decode($resultUser, TRUE);


$balanceController = new BalanceController();
$resultBalance = $balanceController->getBalanceByIdAll();
$resultBalance = json_decode($resultBalance, TRUE);
$count = 0;

?>

    <div class="container-fluid" id="main">
        <div class="col-md-12 mb-2 mt-2">
            <div class="row">
                <button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">Comprar ficha</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Nome Cliente</th>
                      <th scope="col">Valor</th>
                      <th scope="col">Opções</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 

                        foreach ($resultBalance['success'] as $usuario) {
                            echo '<tr>';
                            echo '<td>'.$usuario['name'].'</td>';
                            echo '<td>'.$usuario['value'].'</td>';
                            echo '<td><button class="btn btn-primary" data-toggle="modal" onclick="visualizar('.$usuario['id'].', '.$usuario['id_caixa'].')" data-target="#modal2'.$usuario['id'].'">Visualizar</button>                   
                                      <a href="/user/del/'.$usuario['id'].'"><button onclick="return confirm(\'Tem certeza que deseja excluir?\');" type="button" class="btn btn-danger">Excluir</button></a></td>';                        
                            echo '<tr>'; 
                             $id = $usuario['id'];
                        $id_caixa = $usuario['id_caixa'];                    
                        $count++; }

                       
                    ?>
                  </tbody>
                </table>
            </div>  
        </div>  
    </div>

    <!-- Modal Editar -->

                                <div class="modal fade" id="modal2<?php $id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Visualizar Compras</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body" id="modal2<?.$id.?>">
                                      <table class="table" id="modal2<?.$id.?>">
                                      <thead>
                                        <tr>
                                          <th scope="col">Nome Cliente</th>
                                          <th scope="col">Valor</th>
                                          <th scope="col">Caixa</th>
                                          <th scope="col">Created_at</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      </table>
                                        <form action="/user/'.$usuario['id'].'" method="post" class="form-signin">
                                          <input id="id" class="form-control" value="'.$usuario['id'].'" name="id" type="hidden">                                       
                                          <label for="tipo">Nome:</label>
                                          <input type="text" class="form-control" placeholder="Nome" name="name" value="'.$usuario['name'].'" required autofocus>    
                                          <label for="tipo">Pix ou Ag. e Conta:</label>
                                          <input type="text" class="form-control" placeholder="Pix/ag-conta" name="pix" value="'.$usuario['value'].'" required>
                                          <button class="btn btn-lg btn-primary btn-block" type="submit">Efetuar Pagamento</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>  

                                <!-- Modal Editar -->

    <!-- Modal Adicionar -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Compra de ficha</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">          
            <form method="post" class="form-signin">
              <input type="hidden" name="method" value="compra">
                <label for="tipo">Nome:</label>
                <select id="id_user" name="id_user" multiple="multiple" style="width: 100%">
                  <?php 
                  if(count($resultUser['success'])) { 
                    foreach ($resultUser['success'] as $res) { ?> 
                      <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option> 
                      <?php } } ?> 
                    </select>
                <label for="value">Valor:</label>
                <input type="text" class="form-control" placeholder="Valor" name="value" style="width: 100%" autocomplete="off" required>
                <label for="situacao">Situação:</label>
                <select id="situacao" class="form-control" name="situacao">
                  <option value="0">Pendente</option>
                  <option value="1">Pago</option>
                </select> 
                <button class="btn btn-lg btn-primary btn-block" type="submit">Confirmar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar -->        
    <script type="text/javascript">
      $(document).ready(function() {
    $('#id_user').select2();
});
    </script>
  </body>
</html>

