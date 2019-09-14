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
    $con->_addLog($userID, "Tentou acessar uma área restrita para administradores.", 'Logs');
    header("Location: ../../index.php");
}

$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
$permInfo = mysqli_fetch_assoc($permConsulta);

if(!$permInfo['getViewLogs'] == 1){
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
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap4.css">
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
            <h1>Logs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Logs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Logs do Sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="logs" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>Área</th>
                  <th>Usuário</th>
                  <th>Descrição</th>
                  <th>IP</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $logsList = $con->_query("SELECT * FROM logs ORDER BY id DESC");
                if(@mysqli_num_rows($logsList) == 0){                  
                  ?>
                  <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                  </tr>
                <?php 

                }else{
                  while ($logsInfo = mysqli_fetch_array($logsList)) {
                    $userResp = $con->_getNickName($logsInfo['idUser']);
                  ?>
                  <tr>
                    <td><?php echo $logsInfo['data'];?></td>
                    <td><?php echo $logsInfo['hora'];?></td>
                    <td><?php echo $logsInfo['area'];?></td>
                    <td><?php echo $userResp;?></td>
                    <td><?php echo $logsInfo['acao'];?></td>
                    <td><?php echo $logsInfo['ip'];?></td>
                  </tr>
                <?php }
                }?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>Área</th>
                  <th>Usuário</th>
                  <th>Descrição</th>
                  <th>IP</th>
                </tr></tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>

    </section>
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
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
  $(function () {
    $('#logs').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>