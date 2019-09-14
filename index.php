<?php 

require_once 'includes/functions.php';
//require_once '../includes/sessions.php';
$con = new conDB();
session_start();
require_once 'includes/conexao.php';

$forum = new conDB();
$forum->conexao('localhost', 'root', '', 'forum');


$error = null;
if(isset($_GET['erro'])){
    $error = $_GET['erro'];
}

$var1 = rand(1,10);
$var2 = rand(1,10);
$key = $var1 + $var2;

$ip = $_SERVER['REMOTE_ADDR'];
$isBan = $con->_isBanIP($ip);
?>

<html>
  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>PlayStart - Painel</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="dist/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  </head>
  <?php if(isset($_SESSION['userConectado'])){

    $processoPage = false;
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
    <body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
      <!-- Navbar -->
      <?php include "includes/navbar.php"; ?> 
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <?php include "includes/sidebar.php"; ?> 

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Inicio</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">   
         <div class="card direct-chat direct-chat-primary">
              <div class="card-header ui-sortable-handle">
                <h3 class="card-title">Bate Papo</h3>

                <div class="card-tools">
                  <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" style="display: block;">
                <div class="direct-chat-messages">
                  <?php

                    $mensagens = $con->_query("SELECT * FROM chat ORDER BY id ASC");

                    while ($mensagensI = mysqli_fetch_array($mensagens)) {
                      $nick = $con->_getNickName($mensagensI['userid']);
                      $foto = $forum->_getPhoto($mensagensI['userid']);                    

                      if($userID == $mensagensI['userid']){?>
                        <!-- my Message -->
                        <br>
                        <div class="direct-chat-msg right">
                          <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-right"><?php echo $nick;?></span>
                            <span class="direct-chat-timestamp float-left"><?php echo $mensagensI['time'];?></span>
                          </div>
                          <!-- /.direct-chat-info -->
                          <img class="direct-chat-img" src="<?php echo $foto;?>" alt="message user image">
                          <div class="direct-chat-text">
                            <?php echo $mensagensI['text'];?>
                          </div>
                        </div>
                      <?php }else{?>
                        <!-- whe Message -->
                        <br>
                        <div class="direct-chat-msg">
                          <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-left"><?php echo $nick;?></span>
                            <span class="direct-chat-timestamp float-right"><?php echo $mensagensI['time'];?></span>
                          </div>
                          <img class="direct-chat-img" src="<?php echo $foto;?>" alt="message user image">
                          <div class="direct-chat-text">
                            <?php echo $mensagensI['text'];?>
                          </div>
                        </div>
                      <?php }?>
                    <?php }?>
                </div>
              </div>
              <div class="card-footer" style="display: block;">
                <form action="#" method="post">
                  <div class="input-group">
                    <input type="hidden" name="username" id="username">
                    <input type="text" name="mensagem" id="mensagem" maxlength="256" placeholder="Escreva uma mensagem..." class="form-control">
                    <span class="input-group-append">
                      <button type="button" class="btn btn-primary">Enviar</button>
                    </span>
                  </div>
                </form>
              </div>
            </div>   
        </section>  
      </div>

      <?php include "includes/footer.php"; ?> 

      <aside class="control-sidebar control-sidebar-dark">
      </aside>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/fastclick/fastclick.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
      $( "#result" ).load( "ajax/test.html" );
    </script>
    </body>
  <?php }else{?>
    <?php 
    if($isBan == 0){?>
      <body class="hold-transition login-page">

        <div class="login-box">
          <div class="login-logo">
            <img src="dist/img/logo.png">
          </div>

          <div class="card">
            <div class="card-body login-card-body">
              <p class="login-box-msg">Insira seus dados da conta fórum</p>
              <form id="loginForm" method="post" action="dist/php/validar.php">
                <div class="input-group mb-3">
                  <input type="text" name="login" class="form-control" placeholder="Usuário">
                  <div class="input-group-append input-group-text">
                      <span class="fas fa-envelope"></span>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" name="senha" class="form-control" placeholder="Senha">
                  <div class="input-group-append input-group-text">
                      <span class="fas fa-lock"></span>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="resposta" placeholder="Quanto é  <?php echo $var1;?> + <?php echo $var2;?>?">
                  <input style="display: none;" type="text" class="form-control" name="resultado" value="<?php echo $key;?>">
                  <div class="input-group-append input-group-text">
                      <span class="fas fa-check"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                  </div>
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                  </div>
                </div>
              </form>
              <div class="social-auth-links text-center mb-3">
                <hr>
              </div>

              <p class="mb-1">
                <a href="https://samp.brasilplaystart.com.br/forum/index.php?/lostpassword/">Esqueceu sua senha?</a>
              </p>
              <p class="mb-0">
                <a href="https://samp.brasilplaystart.com.br/forum/index.php?/register/" class="text-center">Não tem conta? Registre-se agora!</a>
              </p>
            </div>
          </div>
        </div>

        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
        <script src="plugins/toastr/toastr.min.js"></script>
        <script src="plugins/fastclick/fastclick.js"></script>
        <script>  
          $(function() {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 7000
            });
            <?php if($error == 101){?>
            $( document ).ready(function() {
              Toast.fire({
                type: 'error',
                title: 'Usuário ou senha incorreto, tente novamente!'
              })
            });

            <?php }elseif($error == 100){?>
            $( document ).ready(function() {
              Toast.fire({
                type: 'error',
                title: 'Codigo de segurança incorreto, tente novamente!'
              })
            });
            <?php }elseif($error == 102){?>
            $( document ).ready(function() {
              Toast.fire({
                type: 'warning',
                title: 'Você acaba de se deslogar do painel!'
              })
            });
            <?php }?>
          });
        </script>
      </body>
    <?php }else{ ?>
      <body class="hold-transition bg-danger">
        <div class="card mt-5">
            <div class="card-body login-card-body">
              <h2 class="login-box-msg"><i class="fas fa-ban" style="font-size: 100px"></i><br><br><br>Você foi banido de nossos sistemas!</h2>
            </div>
          </div>
        </div>

        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
        <script src="plugins/toastr/toastr.min.js"></script>
        <script src="plugins/fastclick/fastclick.js"></script>
      </body>
    <?php } ?>
  <?php }?>

</html>

