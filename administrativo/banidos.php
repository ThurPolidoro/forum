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
  $con->_addAlert($userID, 5);
  $con->_addLog($userID, "Tentou acessar uma área restrita para administradores.", 'Invasão');
  header("Location: ../index.php");
}

$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
$permInfo = mysqli_fetch_assoc($permConsulta);

if(!$permInfo['getBan'] == 1 || !$permInfo['getDesban'] == 1){
  $con->_addLog($userID, "Tentou acessar a área de gerenciamento de banidos, porém não tinha permissão", "Administradores");
  header("Location: ../index.php");
}



?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PlayStart - Gerenciar Administradores</title>
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
<div class="wrapper">
  <?php include "../includes/navbar.php"; ?>
  <?php include "../includes/sidebar.php"; ?> 
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gerenciar Banidos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Gerenciar Banidos</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title text-center">Lista de Banidos</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover"> 
            <tr>
              <th>ID</th>
              <th>Usuário</th>
              <th>Alertas</th>
              <th>Ações</th>
            </tr>                 	
            <?php
              $ban_consulta = $con->_query("SELECT * FROM banidos ORDER BY idBan DESC");
              while ($ban_info = mysqli_fetch_array($ban_consulta)) {
                $nick = $con->_getNickName($ban_info['idForum']);
                $user = $con->_getUser($ban_info['idForum']);
               ?>
                <tr>
                  <td><?php echo $ban_info['idForum']; ?></td>
                  <td><?php echo $nick; ?></td>
                  <td><?php echo $user['alert']; ?></td>
                  <td>
                    <button button type="button" class="btn btn-danger text-white" data-toggle="modal" data-target="#desbanModal-<?php echo $ban_info['idForum']; ?>">
                      <i class="fas fa-times"></i>
                    </button>
                  </td>
                </tr>
              <?php                
                }
              ?>
          </table>
          <button button type="button" class="btn btn-light" data-toggle="modal" data-target="#addModal" style="width: 100%">
          <i class="fas fa-plus"></i>
          </button>
        </div>          
      </div>
    </section>
  </div>
  <?php include "../includes/footer.php"; ?> 

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>            
<!--REMOVER-->
<?php
$ban_consulta = $con->_query("SELECT * FROM banidos ORDER BY idBan DESC");
while ($ban_info = mysqli_fetch_array($ban_consulta)) {
  $nick = $con->_getNickName($ban_info['idForum']);
  $user = $con->_getUser($ban_info['idForum']);
?>
  <div class="modal fade" id="desbanModal-<?php echo $ban_info['idForum']; ?>">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Desbanir</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="Form" method="post" action="../dist/action/desban.php">
          <div class="modal-body text-center">
            <p>Você tem certeza que deseja remover este banimento?</p>
            <input type="hidden" name="id" value="<?php echo $ban_info['idForum']; ?>">
          </div>                             
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            <input type="submit" class="btn btn-primary" value="Sim">
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php } ?>

  <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar Banimento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addForm" method="post" action="../dist/action/ban.php">
          <div class="modal-body text-center">
            <p>Qual o nick do usuário no fórum?</p>
            <input class="form-control" type="text" name="nick" placeholder="Ex: Thur_MaliGnY"><br>
          </div>                             
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <input type="submit" class="btn btn-primary" value="Adicionar">
          </div>
        </form>
      </div>
    </div>
  </div>

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