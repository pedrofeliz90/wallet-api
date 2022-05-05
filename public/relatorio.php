<?php
use Brunosribeiro\WalletApi\Controllers\ExtractController;
use Brunosribeiro\WalletApi\Controllers\UserController;
include "index.php";

$userController = new UserController();
$resultUser = $userController->getAllUsers();
$resultUser = json_decode($resultUser, TRUE);


$extractController = new ExtractController();
$resultExtract = $extractController->getAllTransaction();
$resultExtract = json_decode($resultExtract, TRUE);
$count = 0;

?>

    <div class="container-fluid" id="main">
      <form class="row row-cols-lg-auto g-3 align-items-center" method="post">
        <div class="col-12">
            <div class="row">
              <input type="hidden" name="method" value="pesquisa">
                  <div class="col">
                    <label for="tipo">Nome:</label>
                    <select class="form-control" id="id_user" name="id_user" multiple="multiple">
                        <?php 
                        if(count($resultUser['success'])) { 
                          foreach ($resultUser['success'] as $res) { ?> 
                            <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option> 
                        <?php } } ?> 
                    </select>
                  </div>
                <div class="col">
                  <label for="tipo">Caixa:</label>
                    <select class="form-control" id="idcaixa" name="idcaixa">
                        <?php 
                        if(count($resultUser['success'])) { 
                          foreach ($resultUser['success'] as $res) { ?> 
                            <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option> 
                        <?php } } ?> 
                    </select>
                  </div>
                  <div class="col">
                    <button class="btn btn-md btn-primary" type="submit">Confirmar</button>
                </div>
            </div>
        </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Nome Cliente</th>
                      <th scope="col">Valor</th>
                      <th scope="col">Situação</th>
                      <th scope="col">Data</th>
                      <th scope="col">Opções</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 

                        foreach ($resultExtract['success'] as $usuario) {
                            echo '<tr>';
                            echo '<td>'.$usuario['name'].'</td>';
                            echo '<td>'.$usuario['value'].'</td>';
                            if ($usuario['situacao'] == 0) {
                              $usuario2['situacao'] = "Pendente";
                            }else{
                              $usuario2['situacao'] = "Pago";
                            }
                            echo '<td>'.$usuario2['situacao'].'</td>';
                            echo '<td>'.$usuario['created_at'].'</td>';
                            echo '<td><button class="btn btn-primary" data-toggle="modal" data-target="#modal2'.$usuario['id'].'">Editar</button>                   
                                      <a href="/user/del/'.$usuario['id'].'"><button onclick="return confirm(\'Tem certeza que deseja excluir?\');" type="button" class="btn btn-danger">Excluir</button></a></td>';                        
                            echo '<tr>';

                            echo '<!-- Modal Editar -->

                                <div class="modal fade" id="modal2'.$usuario['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Valor</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="/user/'.$usuario['id'].'" method="post" class="form-signin">
                                          <input id="id" class="form-control" value="'.$usuario['id'].'" name="id" type="hidden">                                       
                                          <label for="tipo">Nome:</label>
                                          <input type="text" class="form-control" placeholder="Nome" name="name" value="'.$usuario['name'].'" disabled="">    
                                          <label for="tipo">Valor:</label>
                                          <input type="text" class="form-control" placeholder="Valor" name="value" value="'.$usuario['value'].'" disabled="">
                                          <label for="tipo">Situacao</label>
                                          <input type="text" class="form-control" value="'.$usuario2['situacao'].'" disabled="">
                                          <label for="situacao">Pago?</label>
                                          <input type="checkbox" id="situacao" name="situacao" value="1" required>
                                          <button class="btn btn-lg btn-primary btn-block" type="submit">Efetuar Pagamento</button>
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
  </body>
  <script type="text/javascript">
      $(document).ready(function() {
    $('#id_user').select2();
});
    </script>
</html>

