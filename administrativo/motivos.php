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

$error = null;
if(isset($_GET['error'])){
    $error = $_GET['error'];
}

$success = null;
if(isset($_GET['success'])){
    $success = $_GET['success'];
}


$user_result = $con->_query("SELECT * FROM usuarios");

if(!isset($_SESSION['userConectado'])){
  header("Location: ../index.php");
}

if($isAdmin == false){
  header("Location: ../index.php");
}

$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
$permInfo = mysqli_fetch_assoc($permConsulta);

if(!$permInfo['getCreateReason'] == 1 || !$permInfo['getRemoveReason'] == 1){
  header("Location: ../index.php");
}



?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PlayStart - Gerenciar Motivos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.9.0/css/pro.min.css">

  <!-- Ionicons -->
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
    
    .vertical-center {
      margin: 0;
      position: absolute;
      top: 50%;
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
    }
  </style>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gerenciar Motivos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Gerenciar Motivos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title text-center">Motivos Adicionados</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover"> 
                    <tr>
                      <th>ID</th>
                      <th>Motivo</th>
                      <th>Motivo Value</th>
                    </tr>                 	
		        	<?php
		        	$motivo_consulta = $con->_query("SELECT * FROM motivo");
               while ($motivo_informacoes = mysqli_fetch_array($motivo_consulta)) {
               ?>
                    <tr>
                      <td><?php echo $motivo_informacoes['id']; ?></td>
                      <td><?php echo $motivo_informacoes['motivo']; ?></td>
                      <td><?php echo $motivo_informacoes['motivoValue']; ?></td>
                    </tr>
                  <?php                
                }?>
                  </table>
                </div>          
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <div class="row">
      <div class="col-lg-6">
        <section class="content ml-auto mr-auto">
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title text-center">Adicionar Motivo</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
                </div>
                    <div class="card-body table-responsive p-0">
                      <form action="../dist/action/addMotivo.php" method="post" id="addForm">
                        <table class="table table-hover"> 
                          <div class="row text-left mr-auto ml-auto" style="max-width: 98%">
                            <div class="col-lg-10 mr-auto ml-auto">
                              <div class="row text-center">
                                <div class="col-lg-6">
                                  <label>Motivo</label>
                                  <input name="motivo" type="text" class="form-control mr-auto ml-auto mb-3" placeholder="Ex: Org X Org" required>
                                </div>
                                <div class="col-lg-6">
                                  <label>Motivo Valor</label>
                                  <input name="motivoValue" type="text" class="form-control mr-auto ml-auto mb-3" placeholder="Ex: orgxorg" required>
                                </div>
                              </div>
                              <input type="submit" name="submit" class="btn btn-block btn-success btn-lg mt-3" value="Adicionar">
                            </div>                 
                          </div>
                        </table>
                      </form>
                    </div>  
            <div class="card-footer">
            </div>
            <!-- /.card-footer-->
          </div>      
        </section>
      </div>
      <div class="col-lg-6">
        <section class="content ml-auto mr-auto">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title text-center">Remover Motivo</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <form action="../dist/action/removeMotivo.php" method="post" id="revForm">
              <table class="table table-hover"> 
                <div class="row text-center mr-auto ml-auto" style="max-width: 98%">
                  <div class="col-lg-10 mr-auto ml-auto">
                    <label class="mt-1">Motivo ID</label>
                    <input name="motivoID" type="text" class="form-control mb-3" placeholder="Ex: 1">
                    <input type="submit" name="submit" class="btn btn-block btn-danger btn-lg mt-3" value="Remover">
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
    <!-- /.content -->
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
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
    <script>  
      $(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 7000
        });
        <?php if($error == 400){?>
        $( document ).ready(function() {
          Toast.fire({
            type: 'error',
            title: 'O motivo que você tentou remover não existe, verifique se digitou corretamente!'
          })
        });

        <?php }elseif($error == 200){?>
        $( document ).ready(function() {
          Toast.fire({
            type: 'error',
            title: 'Você não tem permissões suficiente para fazer isso!'
          })
        });
        <?php }elseif($error == 300){?>
        $( document ).ready(function() {
          Toast.fire({
            type: 'error',
            title: 'Já existe um Motivo com esse motivoValue!'
          })
        });
        <?php }elseif($error == 500){?>
        $( document ).ready(function() {
          Toast.fire({
            type: 'error',
            title: 'Esse motivo não existe, verifique se digitou o ID corretamente!'
          })
        });
        <?php }elseif($success == 100){?>
        $( document ).ready(function() {
          Toast.fire({
            type: 'success',
            title: 'Você criou um novo motivo com sucesso!'
          })
        });
        <?php }elseif($success == 200){?>
        $( document ).ready(function() {
          Toast.fire({
            type: 'success',
            title: 'Você removeu um motivo com sucesso!'
          })
        });
        <?php }?>
      });
    </script>
</body>
</html>