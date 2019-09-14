<?php
require_once '../includes/functions.php';
//require_once '../includes/sessions.php';
$con = new conDB();
session_start();
require_once '../includes/conexao.php';
$processoPage = true;
$userConectado = $_SESSION['userConectado'];
$userID = $_SESSION['userID'];
$cargo = $_SESSION['cargo'];
$isAdmin = $_SESSION['isAdmin'];
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
  }elseif ($page == 'apurados') {
    $tituloArea = 'Processos Apurados';
  }elseif ($page == 'meusprocessos') {
    $tituloArea = 'Meus Processos';
  }else{
    $tituloArea = 'Processos Aguardando';
  }
}

$isResponsavel = $con->_getProcessList($cargo);
if ($isResponsavel == null) {
  $isResponsavel = false;
}else{
  $isResponsavel = true;
}

$user_result = $con->_query("SELECT * FROM usuarios");
if(!isset($_SESSION['userConectado'])){
  header("Location: ../index.php");
}

if($isAdmin == false){  
    $con->_addAlert($userID, '2');
    $con->_addLog($userID, "Tentou acessar uma área restrita para administradores.", 'Punição');
    header("Location: ../../index.php");
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
            <h1>Lista de Punições</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Lista de Punições</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card collapsed-card">
        <div class="card-header">
          <?php
          $qntProcessos = $con->_quantidadePunicoesGravidade();
          ?>
          <span class="right badge badge-danger float-left"><?php echo $qntProcessos;?></span>
          <h3 class="card-title text-center">Punições por Gravidades</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Clique ai talkei!" id="exibirCat">
              <i class="fas fa-plus"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover"> 
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Juiz</th>
              <th>Motivo</th>
              <th>Autor</th>
              <th>Réu</th>
              <th>Gravidade</th>
              <th>Avisos</th>
            </tr>                   
            <?php
              $processo_abertos = $con->_query("SELECT * FROM punicao WHERE gravidade > 0 AND minutos = 0 AND apply = 0");
              $rowProcess = mysqli_num_rows($processo_abertos);
              if ($rowProcess > 0) {
                while ($processo_informacoes = mysqli_fetch_array($processo_abertos)) {
                  $motivoVar =$processo_informacoes['motivo'];
                  $motivo = $con->_getMotivo($motivoVar);                
                  $juiz = $processo_informacoes['juiz'];
                  $juiz = $con->_getNickName($juiz);
                  $autor = $processo_informacoes['autorID'];
                  $autor = $con->_getNickName($autor);
                  $reu = $processo_informacoes['reuID'];
                  $reu = $con->_getNickName($reu);
               ?>
                    <tr id="process" data-toggle="modal" data-target="#detalhes-<?php echo $processo_informacoes['id_processo']; ?>">
                      <td><?php echo $processo_informacoes['id_processo']; ?></td>
                      <td><?php echo $processo_informacoes['data']; ?></td>
                      <td id="juizNick"><?php echo $juiz; ?></td>
                      <td><?php echo $motivo; ?></td>
                      <td><?php echo $autor;?></td>
                      <td id="reuNick"><?php echo $reu;?></td>
                      <td><?php echo $processo_informacoes['gravidade']; ?></td>
                      <td><?php echo $processo_informacoes['avisos']; ?></td>
                    </tr>
                  <?php                
                }

                ?>
                    </table><?php
              }else{
               ?>
                </table>
                <p class="text-center p-3">Não há nenhuma punição em espera! ;)</p>
              <?php
            }?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>


      <div class="card collapsed-card">
        <div class="card-header">
          <?php
          $qntProcessos = $con->_quantidadePunicoesMinutos();
          ?>
          <span class="right badge badge-warning float-left"><?php echo $qntProcessos;?></span>
          <h3 class="card-title text-center">Punições por Minutos</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Clique ai talkei!" id="exibirCat">
              <i class="fas fa-plus"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover"> 
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Juiz</th>
              <th>Motivo</th>
              <th>Autor</th>
              <th>Réu</th>
              <th>Minutos</th>
              <th>Avisos</th>
            </tr>                   
            <?php
              $processo_abertos = $con->_query("SELECT * FROM punicao WHERE gravidade = 0 AND minutos > 0 AND apply = 0");
              $rowProcess = mysqli_num_rows($processo_abertos);
              if ($rowProcess > 0) {
                while ($processo_informacoes = mysqli_fetch_array($processo_abertos)) {
                  $motivoVar =$processo_informacoes['motivo'];
                  $motivo = $con->_getMotivo($motivoVar);                
                  $juiz = $processo_informacoes['juiz'];
                  $juiz = $con->_getNickName($juiz);
                  $autor = $processo_informacoes['autorID'];
                  $autor = $con->_getNickName($autor);
                  $reu = $processo_informacoes['reuID'];
                  $reu = $con->_getNickName($reu);
               ?>
                    <tr id="process" data-toggle="modal" data-target="#detalhes-<?php echo $processo_informacoes['id_processo']; ?>">
                      <td><?php echo $processo_informacoes['id_processo']; ?></td>
                      <td><?php echo $processo_informacoes['data']; ?></td>
                      <td><?php echo $juiz; ?></td>
                      <td><?php echo $motivo; ?></td>
                      <td><?php echo $autor;?></td>
                      <td><?php echo $reu;?></td>
                      <td><?php echo $processo_informacoes['minutos']; ?></td>
                      <td><?php echo $processo_informacoes['avisos']; ?></td>
                    </tr>
                  <?php                
                }
                ?>
                    </table><?php
              }else{
               ?>
                </table>
                <p class="text-center p-3">Não há nenhuma punição em espera! ;)</p>
              <?php
            }?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>


      <div class="card collapsed-card">
        <div class="card-header">
          <?php
          $qntProcessos = $con->_quantidadePunicoesAplicadas();
          ?>
          <span class="right badge badge-success float-left"><?php echo $qntProcessos;?></span>
          <h3 class="card-title text-center">Punições Aplicadas</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Clique ai talkei!" id="exibirCat">
              <i class="fas fa-plus"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover"> 
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Juiz</th>
              <th>Motivo</th>
              <th>Réu</th>
              <th>Gravidade</th>
              <th>Minutos</th>
              <th>Avisos</th>
            </tr>                   
            <?php
              $processo_abertos = $con->_query("SELECT * FROM punicao WHERE apply = 1");
              $rowProcess = mysqli_num_rows($processo_abertos);
              if ($rowProcess > 0) {
                while ($processo_informacoes = mysqli_fetch_array($processo_abertos)) {
                  $motivoVar =$processo_informacoes['motivo'];
                  $motivo = $con->_getMotivo($motivoVar);                
                  $juiz = $processo_informacoes['juiz'];
                  $juiz = $con->_getNickName($juiz);
                  $autor = $processo_informacoes['autorID'];
                  $autor = $con->_getNickName($autor);
                  $reu = $processo_informacoes['reuID'];
                  $reu = $con->_getNickName($reu);
               ?>
                    <tr id="process" data-toggle="modal" data-target="#detalhes-<?php echo $processo_informacoes['id_processo']; ?>">
                      <td><?php echo $processo_informacoes['id_processo']; ?></td>
                      <td><?php echo $processo_informacoes['data']; ?></td>
                      <td><?php echo $juiz; ?></td>
                      <td><?php echo $motivo; ?></td>
                      <td><?php echo $reu;?></td>
                      <td><?php echo $processo_informacoes['gravidade']; ?></td>
                      <td><?php echo $processo_informacoes['minutos']; ?></td>
                      <td><?php echo $processo_informacoes['avisos']; ?></td>
                    </tr>
                  <?php                
                }
                ?>
                    </table><?php
              }else{
               ?>
                </table>
                <p class="text-center p-3">Não há nenhuma punição em espera! ;)</p>
              <?php
            }?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
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
            title: 'Clique no + para expandir a categoria.'
          })
        });

        $( "#exibirCat" ).click(function() {
          Toast.fire({
            type: 'info',
            title: 'Clique sobre o processo para acessar a área de detalhes.'
          })        
        });
      });
</script>

<script>
  function viewProcess(id) {
    window.location.href = "processo.php?id="+id;
  }
</script>
<?php
  
  $punicao_abertos = $con->_query("SELECT * FROM punicao");
  while ($punicaoInfo = mysqli_fetch_array($punicao_abertos)){
    $idProcesso = $punicaoInfo['id_processo'];
    $applyPuni = $punicaoInfo['apply'];
    $processo_abertos = $con->_query("SELECT * FROM processos WHERE id = '$idProcesso'");
    $processoInfo = mysqli_fetch_array($processo_abertos);
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
    $responsavel = $con->_getNickName($responsavel);
    
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
          <input style="display: none;" type="text" name="gambiarra" id="comando-<?php echo $processoInfo['id']; ?>" value="/sentenciar <?php echo $reuNick; ?> <?php echo $punicaoInfo['minutos']; ?> <?php echo $punicaoInfo['avisos']; ?> <?php echo $idProcesso; ?> <?php echo $responsavel; ?>">
          <?php 
            if ($applyPuni == 0){
          ?>
          <a onclick="copiarTextoMin(<?php echo $processoInfo['id']; ?>);" class="btn btn-primary text-white">Copiar Comando</a>
          <a onclick="punicaoAplicada(<?php echo $processoInfo['id']; ?>);" class="btn btn-primary text-white">Punição Aplicada</a>

          <?php 
            }else{
          ?>
            <a href="<?php echo $punicaoInfo['provas']; ?>" target="_blank" class="btn btn-primary text-white">Print do Comprovante</a>
          <?php 
            }
          ?>

          <a href="processo.php?id=<?php echo $processoInfo['id']; ?>" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    </div>
  </div>
<?php
}?>
<script>
    function copiarTextoMin(id) {
      var textoCopiado = document.getElementById("comando-" + id);
      textoCopiado.select();
      document.execCommand("Copy");
      alert("Comando Copiado!");
    }
    function punicaoAplicada(id) { 

      var provas = prompt("Insira o link do print da cadeia aplicada", "https://imgur.com/exemplo");
      if (provas == null || provas == "") {
      } else {
        if (confirm('Você tem certeza que quer dar como punição aplicada?')) {
          window.location.assign("../dist/action/applyPunish.php?id=" + id + "&url=" + provas);
        } else {        
          txt = "Você cancelou a ação!";
        } 
      }
    }
</script>
</body>
</html>