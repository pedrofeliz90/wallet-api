<?php
use Brunosribeiro\WalletApi\Controllers\UserController;
include "index.php";

class Cashgame {

    public function adduser($dados) {
        $params = $_POST;
        $userController = new UserController();
        $result = $userController->addUser($params);
        $result = json_decode($result, TRUE);
        if (isset($result['success'])) {
          echo $result['success'];
        }elseif (isset($result['error'])){
          echo $result['error'];
        }elseif (isset($result['warning'])){
          echo $result['warning'];
        }
        
    }
    public function editar($dados) {
        $data = $_POST;
        $id = $data['id'];
        $userController = new UserController();
        $result = $userController->editUser($id, $data);
        $result = json_decode($result, TRUE);
        if (isset($result['success'])) {
          echo $result['success'];
        }elseif (isset($result['error'])){
          echo $result['error'];
        }elseif (isset($result['warning'])){
          echo $result['warning'];
        }
    }
    public function delete($dados) {
        //return confirm('Tem certeza que deseja excluir?');
        $data = $_POST;
        $id = $data['id'];
        $userController = new UserController();
        $result = $userController->deleteUser($id);
        $result = json_decode($result, TRUE);
        if (isset($result['success'])) {
          echo $result['success'];
        }elseif (isset($result['error'])){
          echo $result['error'];
        }elseif (isset($result['warning'])){
          echo $result['warning'];
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
$result = $userController->getAllUsers();
$result = json_decode($result, TRUE);
$count = 0;

?>


    <div class="container-fluid" id="main">
        <div class="col-md-12 mb-2 mt-2">
            <div class="row">
                <button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">Adicionar novo usuário</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Nome</th>
                      <th scope="col">Pix</th>
                      <th scope="col">Saldo</th>
                      <th scope="col">Tipo</th>
                      <th scope="col">Opções</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 

                        foreach ($result['success'] as $usuario) {
                            echo '<tr>';
                            echo '<td>'.$usuario['name'].'</td>';
                            echo '<td>'.$usuario['pix'].'</td>';
                            echo '<td>'.$usuario['saldo'].'</td>';
                            if ($usuario['tipo'] == 0) {
                              $usuario['tipo'] = "Jogador";
                            }else{
                              $usuario['tipo'] = "Crupie";
                            }
                            echo '<td>'.$usuario['tipo'].'</td>';
                            echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#modal2'.$usuario['id'].'">Editar</button>
                                      <form method="post"><button type="submit" class="btn btn-danger"><input type="hidden" name="method" value="delete"><input type="hidden" name="id" value="'.$usuario['id'].'">Delete</button></form></a></td>';
                            echo '<tr>';

                            echo '<!-- Modal Editar -->

                                <div class="modal fade" id="modal2'.$usuario['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar usuário</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form method="post" class="form-signin">
                                        <input type="hidden" name="method" value="editar">
                                          <input id="id" class="form-control" value="'.$usuario['id'].'" name="id" type="hidden">                                       
                                          <label for="tipo">Nome:</label>
                                          <input type="text" class="form-control" placeholder="Nome" name="name" value="'.$usuario['name'].'" required autofocus>    
                                          <label for="tipo">Pix ou Ag. e Conta:</label>
                                          <input type="text" class="form-control" placeholder="Pix/ag-conta" name="pix" value="'.$usuario['pix'].'" required>
                                          <label for="tipo">Saldo:</label>
                                          <input type="text" class="form-control" placeholder="Saldo" name="saldo" value="'.$usuario['saldo'].'" required>
                                          <label for="tipo">Tipo: 0 = Jogador | 1 = Crupie</label>
                                          <input type="text" class="form-control" placeholder="Tipo" name="tipo" value="'.$usuario['tipo'].'" required>
                                          <button class="btn btn-lg btn-primary btn-block" type="submit">Atualizar cadastro</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>  

                                <!-- Modal Editar -->';                     
                        $count++; }
                    ?>
                  </tbody>
                </table>
            </div>  
        </div>  
    </div>

    <!-- Modal Adicionar -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Adicionar Usuário</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">          
            <form method="post" class="form-signin">
              <input type="hidden" name="method" value="adduser">
                <label for="tipo">Nome:</label>
                <input type="text" class="form-control" placeholder="Nome" name="name" required autofocus>
                <label for="tipo">Pix ou Ag. e Conta:</label>
                <input type="text" class="form-control" placeholder="Pix/ag-conta" name="pix" required>
                 <label for="tipo">Tipo:</label>
                    <select id="tipo" class="form-control" name="tipo">
                      <option value="0">Jogador</option>
                      <option value="1">Crupie</option>
                    </select> 
                <button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar novo usuário</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar -->        
  </body>
</html>

