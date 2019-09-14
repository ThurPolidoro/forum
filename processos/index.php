<?php
require_once '../includes/functions.php';
//require_once '../includes/sessions.php';
$con = new conDB();
session_start();
require_once '../includes/conexao.php';
if(!isset($_SESSION['userConectado'])){
  header("Location: ../index.php");
}
$processoPage = true;
$userConectado = $_SESSION['userConectado'];
$userID = $_SESSION['userID'];
$cargo = $_SESSION['cargo'];
$isAdmin = $_SESSION['isAdmin'];
$isJuri = $_SESSION['isJuri'];
if($isAdmin == true){
  $permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
  $permInfo = mysqli_fetch_assoc($permConsulta);
}

$page = null;
$tituloArea = 'Processos Aguardando';

if (isset($_GET['page'])) {
  $page = $_GET['page'];

  if ($page == 'andamento') {
    $tituloArea = 'Processos em Andamento';
  }elseif ($page == 'apurado') {
    $tituloArea = 'Processos Apurados';
  }elseif ($page == 'aguardando') {
    $tituloArea = 'Processos Aguardando';
  }else{
    $tituloArea = 'Meus Processos';
  }
}

$isResponsavel = $con->_getProcessList($cargo);
if ($isResponsavel == null) {
  $isResponsavel = false;
}else{
  $isResponsavel = true;
}

$user_conexao = $con->_query("SELECT * FROM usuarios WHERE idForum = '$userID'");
$user_result = mysqli_fetch_array($user_conexao);
if($user_result['alert'] >= 30 ){
  $ip = $_SERVER['REMOTE_ADDR'];
  $con->_query("INSERT INTO banidos (idForum, ip) VALUES ('$userID', '$ip')");
  session_destroy();
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
  <style>
    #process{cursor: pointer !important;}
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
            <h1><?php echo $tituloArea;?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Processos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

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
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script>  
      $(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4000
        });
        $( document ).ready(function() {
          Toast.fire({
            type: 'info',
            title: 'Clique no + para visualizar os processos da area.'
          })
        });

        $( "#exibirCat" ).click(function() {
          if($('#card').hasClass('collapsed-card')){
            Toast.fire({
              type: 'info',
              title: 'Clique sobre o processo para acessar os detalhes.'
            })
          }      
        });
      });
</script>

<script>
  function viewProcess(id) {
    window.location.href = "processo.php?id="+id;
  }

  </script>
<?php

  $processo_abertos =  null;
  if($page == 'andamento'){
    $processo_abertos = $con->_query("SELECT * FROM processos WHERE status = 'Em andamento' AND deletado = 0");

  }elseif($page == 'meusprocessos'){
    $processo_abertos = $con->_query("SELECT * FROM processos WHERE reuID = '$userID' AND deletado = 0 OR autorID = '$userID' AND deletado = 0");

  }elseif($page == 'apurado'){
    $processo_abertos = $con->_query("SELECT * FROM processos WHERE status = 'Apurado' AND deletado = 0 OR status = 'Punição Aplicada' AND deletado = 0 OR status = 'Reprovado' AND deletado = 0");
  }else{
    $processo_abertos = $con->_query("SELECT * FROM processos WHERE status = 'Aguardando' AND deletado = 0 ORDER BY id ASC");
  }
  while ($processoInfo = mysqli_fetch_array($processo_abertos)){
    $area = $processoInfo['area'];
    $area = $processoInfo['area'];
    $processoID = $processoInfo['id'];
    $data = $processoInfo['data'];
    $hora = $processoInfo['hora'];
    $ip = $processoInfo['ip'];
    $motivoVar = $processoInfo['motivo'];
    $provas = $processoInfo['provas'];
    $status = $processoInfo['status'];
    $autorID = $processoInfo['autorID'];
    $autorNick = $processoInfo['autorNick'];
    $autorOrg = $processoInfo['autorOrg'];
    $reuID = $processoInfo['reuID'];
    $reuNick = $processoInfo['reuNick'];
    $reuOrg = $processoInfo['reuOrg'];
    $responsavel = $processoInfo['respID'];
    $descricao = $processoInfo['descricao'];
    $motivo = $con->_getMotivo($motivoVar);
  ?>
  <div class="modal fade" id="detalhes-<?php echo $processoInfo['id']; ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="tituloID">Detalhes do Processo de Nº<?php echo $processoInfo['id']; ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          
                    <?php if($area == 'Player' || $area == 'Cheater' || $area == 'Caloteiro'){?>
                      <?php if($status == "Aguardando"){?>
                        O(a) jogador (a) <b><?php echo $autorNick;?></b>, pertencente à organização <b><?php echo $autorOrg;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) jogador (a) <b><?php echo $reuNick;?></b>, pertencente à organização <b><?php echo $reuOrg;?></b>, por suposta pratica de <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a>.
                        <br>Este processo está aguardando um Juiz.
                      <?php }else{?>
                        O(a) jogador (a) <b><?php echo $autorNick;?></b>, pertencente à organização <b><?php echo $autorOrg;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) jogador (a) <b><?php echo $reuNick;?></b>, pertencente à organização <b><?php echo $reuOrg;?></b>, por suposta pratica de <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a>.
                        <br>Este processo está sendo analisado pelo Juiz <b><?php echo $responsavel;?></b>.
                      <?php }?>
                    <?php }elseif($area == 'Lider/Sublideres'){?>
                      <?php if($status == "Aguardando"){?>
                        O(a) jogador (a) <b><?php echo $autorNick;?></b>, pertencente à organização <b><?php echo $autorOrg;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) lider <b><?php echo $reuNick;?></b>, pertencente à organização <b><?php echo $reuOrg;?></b>, por suposta pratica de <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a>.
                        <br>Este processo está aguardando um Juiz.
                      <?php }else{?>
                        O(a) jogador (a) <b><?php echo $autorNick;?></b>, pertencente à organização <b><?php echo $autorOrg;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) lider <b><?php echo $reuNick;?></b>, pertencente à organização <b><?php echo $reuOrg;?></b>, por suposta pratica de <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a>.
                        <br>Este processo está sendo analisado pelo Juiz <b><?php echo $responsavel;?></b>.
                      <?php }?>
                    <?php }elseif($area == 'Staff Server'){?>
                      <?php if($status == "Aguardando"){?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a> 
                      <br>Este processo está aguardando um Juiz.
                      <?php }else{?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a> 
                        <br>Este processo está sendo analisado pelo Juiz <b><?php echo $responsavel;?></b>.
                      <?php }?>
                    <?php }elseif($area == 'Staff TS3'){?>
                      <?php if($status == "Aguardando"){?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a> 
                      <br>Este processo está aguardando um Juiz.
                      <?php }else{?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a> 
                        <br>Este processo está sendo analisado pelo Juiz <b><?php echo $responsavel;?></b>.
                      <?php }?>
                    <?php }elseif($area == 'Staff Fórum'){?>
                      <?php if($status == "Aguardando"){?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a> 
                      <br>Este processo está aguardando um Juiz.
                      <?php }else{?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a> 
                        <br>Este processo está sendo analisado pelo Juiz <b><?php echo $responsavel;?></b>.
                      <?php }?>
                    <?php }elseif($area == 'Juiz'){?>
                      <?php if($status == "Aguardando"){?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por suposta prática de <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a>  
                      <br>Este processo está aguardando um Desembargador.
                      <?php }else{?>
                      O(a) jogador (a) <b><?php echo $autorNick;?></b>, está acusando, no dia <b><?php echo $data;?></b>, o(a) <b><?php echo $reuOrg;?></b> (a) <b><?php echo $reuNick;?></b>, por suposta prática de <b><?php echo $motivo;?></b>, com base nas provas que seguem: <a href="<?php echo $provas;?>" target="_blank"><?php echo $provas;?></a>  
                      <br>Este processo está sendo analisado pelo Desembargador <b><?php echo $responsavel;?></b>.
                      <?php }?>
                    <?php }?>      
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
          <a href="processo.php?id=<?php echo $processoInfo['id']; ?>" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    </div>
  </div>
<?php
}?>
</body>
</html>