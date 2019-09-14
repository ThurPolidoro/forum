<?php

require_once '../includes/functions.php';

//require_once '../includes/sessions.php';

$con = new conDB();
session_start();
require_once '../includes/conexao.php';
$userConectado = $_SESSION['userConectado'];

$userID = $_SESSION['userID'];
$isAdmin = $_SESSION['isAdmin'];
$cargo = $_SESSION['cargo'];


$user_result = $con->_query("SELECT * FROM usuarios");

if(!isset($_SESSION['userConectado'])){
  header("Location: ../index.php");
}

if($isAdmin == false){  
    $con->_addLog($userID, "Tentou acessar uma área restrita para administradores.", 'Cargos');
    header("Location: ../../index.php");
}

$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
$permInfo = mysqli_fetch_assoc($permConsulta);

if(!$permInfo['getCreateRole'] == 1 || !$permInfo['getDeleteRole'] == 1){
  header("Location: ../index.php");
}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PlayStart - Processos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.9.0/css/pro.min.css">

  <!-- Ionicons -->
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include "../includes/navbar.php"; ?> 
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->

  <?php include "../includes/sidebar.php"; ?> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper p-3">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Criar/Permitir Cargos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Criar/Permitir Cargos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Aviso!</h5>
          Na versão 1.x do painel MGY os cargos era configurado com nivel de poder, porem agora é por permissões em seus cargos, a lógica é, o sistema vai verificar se ele é admin e vai pegar o cargo dele e verificar se ele tem a permissão, caso o tenha o acesso será considerado, o cargo padrão é <b>"Master"</b> com acesso <b>geral</b> pórem pode efetuar a edição de nome ou de permissão do mesmo.
      </div>
      <div class="row"> 
        <div class="col-lg-6">
          <section class="content ml-auto mr-auto">
          <div class="card collapsed-card">
            <div class="card-header bg-success">
              <h3 class="card-title text-center">Criar Cargo</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-plus"></i></button>
              </div>
            </div>
            <div class="card-body table-responsive p-0">
              <form method="post" action="../dist/action/addRole.php">
                <table class="table table-hover"> 
                  <div class="row text-center mr-auto ml-auto" style="max-width: 98%">
                    <div class="col-lg-10 mr-auto ml-auto">
                      <label class="mt-1">Nome do Cargo</label>
                      <input type="text" name="nameRole" class="form-control mb-3" placeholder="Ex: Juiz" required>
                      <input type="submit" class="btn btn-block btn-success btn-lg mt-3" value="Adicionar">
                    </div>                 
                  </div>
                </table>
              </form>
            </div>  
            <div class="card-footer">
            </div>
          </div>      
        </div>   
        <div class="col-lg-6">
          <section class="content ml-auto mr-auto">
          <div class="card collapsed-card">
            <div class="card-header bg-danger">
              <h3 class="card-title text-center">Remover Cargo</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-plus"></i></button>
              </div>
            </div>
            <div class="card-body table-responsive p-0">
              <form method="post" action="../dist/action/removeRole.php">
                <table class="table table-hover"> 
                  <div class="row text-center mr-auto ml-auto" style="max-width: 98%">
                    <div class="col-lg-10 mr-auto ml-auto">
                      <label class="mt-1">Nome do Cargo</label>
                      <input type="text" name="nameRole" class="form-control mb-3" placeholder="Ex: Juiz" required>
                      <input type="submit" class="btn btn-block btn-danger btn-lg mt-3" value="Remover">
                    </div>                 
                  </div>
                </table>
              </form>
            </div>  
            <div class="card-footer">
            </div>
          </div>      
          </section> 
        </div>
      </div>     
      <div class="row"> 
        <div class="col-lg-12">
          <h3 class="ml-3 mt-3">ID/Cargos/Membros</h3>
          <section class="content ml-auto mr-auto">
            <?php
            $query = $con->_query("SELECT * FROM permissoes ORDER BY id");
            while($info = mysqli_fetch_array($query)){       
            $membros = 10;
            ?>
            <div class="card collapsed-card">
              <div class="card-header bg-secondary">
                <h3 class="card-title text-left"><?php echo $info['id']; ?>  /  <?php echo $info['name']; ?>  /  <?php echo $membros; ?></h3>
                <div class="card-tools">
                 <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                   <i class="fas fa-plus"></i></button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <form method="post" action="../dist/action/managerPermition.php?id=<?php echo $info['id']; ?>">
                  <table class="table table-hover"> 
                    <div class="row  mr-auto ml-auto" style="max-width: 98%">
                      <div class="col-lg-12 mt-1 mb-1" style="border-bottom: 2px solid #000;">
                        <div class="row">
                          <div class="col-sm-8"><h4>Permissão</h4></div>
                          <div class="col-sm-4"><h4>Status</h4></div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Pegar Processo de Player</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[0]" type="hidden" value="0">
                                <input name="perm_list[0]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Player" value="1" <?php if ($info['getPlayer'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>Player"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div> 
                     <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Pegar Processo de Lideres/Sublideres</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[1]" type="hidden" value="0">
                                <input name="perm_list[1]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Lideres" value="1" <?php if ($info['getLider'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>Lideres"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1">
                        <div class="row">
                         <div class="col-sm-8">Pegar Processo de Staff</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[2]" type="hidden" value="0">
                                <input name="perm_list[2]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Staff" value="1" <?php if ($info['getStaff'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>Staff"></label>
                              </div>
                           </div>
                          </div>
                        </div>
                      </div>  
                      <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Pegar Processo de Cheater</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[3]" type="hidden" value="0">
                                <input name="perm_list[3]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Cheater" value="1" <?php if ($info['getCheater'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>Cheater"></label>
                              </div>
                            </div>
                          </div>
                       </div>
                      </div>   
                      <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Pegar Processo de Caloteiros</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[4]" type="hidden" value="0">
                                <input name="perm_list[4]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Caloteiros" value="1" <?php if ($info['getCaloteiro'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>Caloteiros"></label>
                              </div>
                           </div>
                          </div>
                        </div>
                      </div> 
                      <div class="col-lg-12 mt-1">
                       <div class="row">
                        <div class="col-sm-8">Pegar Processo de Fórum</div>
                         <div class="col-sm-4">
                            <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[5]" type="hidden" value="0">
                               <input name="perm_list[5]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Forum" value="1" <?php if ($info['getForum'] == 1) {echo 'checked';} ?>>
                               <label class="custom-control-label" for="processo<?php echo $info['id'];?>Forum"></label>
                             </div>
                           </div>
                        </div>
                       </div>
                      </div> 
                     <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Pegar Processo de TS3</div>
                         <div class="col-sm-4">
                            <div class="form-group">
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[6]" type="hidden" value="0">
                                <input name="perm_list[6]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>TS3" value="1" <?php if ($info['getTS'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>TS3"></label>
                              </div>
                           </div>
                          </div>
                        </div>
                      </div> 
                      <div class="col-lg-12 mt-1 mb-1">
                       <div class="row">
                          <div class="col-sm-8">Pegar Processo de Juiz</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[7]" type="hidden" value="0">
                              <input name="perm_list[7]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Juiz" value="1" <?php if ($info['getJuiz'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>Juiz"></label>
                              </div>
                            </div>
                          </div>
                       </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1">
                        <div class="row">
                          <div class="col-sm-8">Deletar Processo</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[8]" type="hidden" value="0">
                              <input name="perm_list[8]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>Deletar" value="1" <?php if ($info['getDel'] == 1) {echo 'checked';} ?>>
                              <label class="custom-control-label" for="processo<?php echo $info['id'];?>Deletar"></label>
                             </div>
                          </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1">
                        <div class="row">
                          <div class="col-sm-8">Ver Processo Deletados</div>
                          <div class="col-sm-4">

                          <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[9]" type="hidden" value="0">
                                <input name="perm_list[9]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>VerDel" value="1" <?php if ($info['getViewDel'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>VerDel"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1" style="border-bottom: 2px solid #000;">
                        <div class="row">
                          <div class="col-sm-8">Deletar Processo Permanentemente</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[10]" type="hidden" value="0">
                                <input name="perm_list[10]" type="checkbox" class="custom-control-input" id="processo<?php echo $info['id'];?>DelPerm" value="1" <?php if ($info['getDelPerm'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="processo<?php echo $info['id'];?>DelPerm"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Criar Motivo</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[11]" type="hidden" value="0">
                                <input name="perm_list[11]" type="checkbox" class="custom-control-input" id="criarMotivo<?php echo $info['id'];?>" value="1" <?php if ($info['getCreateReason'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="criarMotivo<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1" style="border-bottom: 2px solid #000;">
                        <div class="row">
                         <div class="col-sm-8">Remover Motivo</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[12]" type="hidden" value="0">
                                <input name="perm_list[12]" type="checkbox" class="custom-control-input" id="removerMotivo<?php echo $info['id'];?>" value="1" <?php if ($info['getRemoveReason'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="removerMotivo<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                         </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Criar Cargo</div>
                          <div class="col-sm-4">
                           <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[13]" type="hidden" value="0">
                                <input name="perm_list[13]" type="checkbox" class="custom-control-input" id="criarCargo<?php echo $info['id'];?>" value="1" <?php if ($info['getCreateRole'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="criarCargo<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                     <div class="col-lg-12 mt-1">
                        <div class="row">
                          <div class="col-sm-8">Deletar Cargo</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[14]" type="hidden" value="0">
                                <input name="perm_list[14]" type="checkbox" class="custom-control-input" id="deletarCargo<?php echo $info['id'];?>" value="1" <?php if ($info['getDeleteRole'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="deletarCargo<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1" style="border-bottom: 2px solid #000;">
                        <div class="row">
                          <div class="col-sm-8">Gerenciar Permissões</div>
                          <div class="col-sm-4">

                           <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[15]" type="hidden" value="0">
                                <input name="perm_list[15]" type="checkbox" class="custom-control-input" id="genPermissoes<?php echo $info['id'];?>" value="1" <?php if ($info['getManagerPermition'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="genPermissoes<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1">

                       <div class="row">
                          <div class="col-sm-8">Dar Cargo</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[16]" type="hidden" value="0">
                                <input name="perm_list[16]" type="checkbox" class="custom-control-input" id="darCargo<?php echo $info['id'];?>" value="1" <?php if ($info['getGiveRole'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="darCargo<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1" style="border-bottom: 2px solid #000;">
                        <div class="row">
                          <div class="col-sm-8">Retirar Cargo</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[17]" type="hidden" value="0">
                                <input name="perm_list[17]" type="checkbox" class="custom-control-input" id="retirarCargo<?php echo $info['id'];?>" value="1" <?php if ($info['getRemoveRole'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="retirarCargo<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-lg-12 mt-1 mb-1" style="border-bottom: 2px solid #000;">
                        <div class="row">
                          <div class="col-sm-8">Ver Logs</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[18]" type="hidden" value="0">
                                <input name="perm_list[18]" type="checkbox" class="custom-control-input" id="verLogs<?php echo $info['id'];?>" value="1" <?php if ($info['getViewLogs'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="verLogs<?php echo $info['id'];?>"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1" style="border-bottom: 2px solid #000;">
                        <div class="row">
                          <div class="col-sm-8">Ver Punições</div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="perm_list[19]" type="hidden" value="0">
                                <input name="perm_list[19]" type="checkbox" class="custom-control-input" id="verPunicoes<?php echo $info['id'];?>" value="1" <?php if ($info['getViewPunishment'] == 1) {echo 'checked';} ?>>
                                <label class="custom-control-label" for="verPunicoes<?php echo $info['id'];?>"></label>
                              </div>
                           </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 mt-1 mb-1">
                        <div class="row">
                          <div class="col-lg-2 ml-auto">
                            <div class="form-group">
                              <input type="submit" value="Salvar" class="btn btn-block btn-success btn-sm" id="salvar">
                            </div>
                         </div>
                        </div>
                      </div>
                    </div>
                  </table>
                </form>
              </div>
            </div>
            <?php }?>    
          </section> 
        </div>
    </div>
 </div>
  <!-- /.content-wrapper -->

 <?php include "../includes/footer.php"; ?> 

 <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<script src="../dist/js/demo.js"></script>
</body>

</html>