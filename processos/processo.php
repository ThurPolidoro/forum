<?php



require_once '../includes/functions.php';
//require_once '../includes/sessions.php';
$con = new conDB();
session_start();
require_once '../includes/conexao.php';
$processoPage = true;
$userConectado = $_SESSION['userConectado'];
$userID = $_SESSION['userID'];
$isAdmin = $_SESSION['isAdmin'];
$cargo = $_SESSION['cargo'];
$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
$permInfo = mysqli_fetch_assoc($permConsulta);



$user_result = $con->_query("SELECT * FROM usuarios");
if(!isset($_SESSION['userConectado'])){
  header("Location: ../index.php");
}




$processoID = null;
if (isset($_GET['id'])) {
  $processoID = $_GET['id'];
}else{
  header("Location: ../error404.php");
}



$processoInfo = $con->_getInfoProcess($processoID);

if($processoInfo == 0)
  header("Location: ../error404.php");




/*Variaveis*/

$area = $processoInfo['area'];
$processoID = $processoInfo['id'];
$data = $processoInfo['data'];
$hora = $processoInfo['hora'];
$ip = $processoInfo['ip'];
$motivo = $processoInfo['motivo'];
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
$access = $processoInfo['access'];
$visibile = $processoInfo['visibile'];
$deletado = $processoInfo['deletado'];
/*---------*/


if($deletado == 1 && !$isAdmin){
  header("Location: ../error404.php");
}


//Pegar o responsável atual

if($processoInfo['respID'] == "0"){
  $responsavel = "Aguardando";
}else{
  $responsavel = $con->_getNickName($responsavel);
}

//

//Verificar permissões se pode pegar o processo

$getProcess = $con->_getProcess($processoID, $cargo);
//
//Atualizar de Motivo Value para Motivo Style (Ex: antirpg -> Anti RPG)

$motivo = $con->_getMotivo($motivo);


$varScroll = "";
if (isset($_GET['scroll'])) {
  $varScroll = $_GET['scroll'];
}



if($varScroll == "end"){?> 

  <script>
    function onLoads(){
      window.scrollTo(0,document.body.scrollHeight);
    }

  </script>
<?php

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
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <style type="text/css">
    .card-info:not(.card-outline) .card-header a {
      color: #000;
    }

  </style>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
  <body class="hold-transition sidebar-mini" onload="onLoads();">
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
              <h1>Processo</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Processo</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


      <!-- Main content -->
      <section class="content">

        <?php if($deletado == 1){?>
        <div class="alert alert-warning alert-dismissible">
          <h5><i class="icon fas fa-eye-slash"></i> Este processo se encontra em modo deletado.</h5>
        </div>
        <?php 
        } 
        if($visibile == 0){?>
        <div class="alert alert-warning alert-dismissible">
          <h5><i class="icon fas fa-eye-slash"></i> Este processo se encontra em modo oculto.</h5>
        </div>
        <?php 

        }

        if($access == 0){?>
        <div class="alert alert-danger alert-dismissible">
          <h5><i class="icon fas fa-lock"></i> Este processo se encontra trancado.</h5>
        </div>
        <?php
      }
        if($status == 'Apurado'){?>
        <div class="alert alert-success alert-dismissible">
          <h5><i class="icon fas fa-check"></i> Este processo foi resolvido.</h5>
        </div>
        <?php 
        }if($status == 'Aguardando'){?>
        <div class="alert alert-warning alert-dismissible">
          <h5><i class="icon fas fa-exclamation"></i> Este processo está aguardando um Juiz.</h5>
        </div>
        <?php 
        }

        ?>
          <!--Resumo-->
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-8">
                  <h2 class="card-title mt-auto mb-auto" style="padding: 7px;">Processo contra <?php echo $area; ?> nº <?php echo $processoID;?></h2>
                </div>
                <div class="col-4">
                  <?php if($isAdmin == true && $getProcess == true){?>
                  <div class="btn-group" style="position: absolute;right: 0;">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      Moderação <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, 38px, 0px);">
                      <?php if($access == 1){?>
                      <a class="dropdown-item" href="../dist/action/moderationAction.php?action=lock&id=<?php echo $processoID;?>">Trancar</a>
                      <?php }else{?>
                      <a class="dropdown-item" href="../dist/action/moderationAction.php?action=unlock&id=<?php echo $processoID;?>">Destrancar</a>
                      <?php }?>
                      <?php if($visibile == 1){?>
                      <a class="dropdown-item" href="../dist/action/moderationAction.php?action=hide&id=<?php echo $processoID;?>">Ocultar</a>
                      <?php }else{?>
                      <a class="dropdown-item" href="../dist/action/moderationAction.php?action=show&id=<?php echo $processoID;?>">Exibir</a>
                      <?php }?>

                      <?php if($deletado == 0){?>
                      <a class="dropdown-item" onclick="deletar(<?php echo $processoID;?>);">Deletar</a>
                      <?php }else{?>
                      <a class="dropdown-item" onclick="restore(<?php echo $processoID;?>);">Restaurar</a>
                      <?php }?>
                      <button type="button" class="dropdown-item" data-toggle="modal" data-target="#moveModal">Mover</button>
                      



                      <?php if($userID == $processoInfo['respID']){?>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" onclick="requestJuri(<?php echo $processoID;?>);">Solicitar Juri</a>
                      <?php }?>
                      <div class="dropdown-divider"></div>


                      <?php if($processoInfo['respID'] == 0){?>
                      <a class="dropdown-item" href="../dist/action/moderationAction.php?action=getprocess&id=<?php echo $processoID;?>">Pegar Processo</a>
                      <?php }?>


                      <?php if($userID == $processoInfo['respID'] &&  $processoInfo['status'] == 'Em andamento'){?>
                      <button type="button" class="dropdown-item" data-toggle="modal" data-target="#aprovarModalLobby">Aprovar Processo</button>
                      <a class="dropdown-item" href="../dist/action/moderationAction.php?action=reprovedprocess&id=<?php echo $processoID;?>">Processo Reprovado</a>
                      <?php }?>
                    </div>
                  </div>
                  <?php }?>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row text-center">
                <div class="col-lg-12 col-12">
                  <div class="col-10 mr-auto ml-auto">
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
                </div>
              </div>
            </div>
            <div class="card-footer">
              

            </div>
          </div>  


        <?php 
        if ($visibile == 1) {
                  
        
        ?>

          <!--DESCRICAO-->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-success">
                  <h5 class="card-title ">Depoimento de <?php echo $autorNick;?> (Autor)</h5>


                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12 ml-auto mr-auto">
                      <?php echo $descricao;?>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row" style="font-size: 10px">
                    <!--Data + Editado-->
                    <div class="col-sm-8">
                      Comentário feito no dia <?php echo $data;?> às <?php echo $hora;?>
                    </div>
                    <!--IP-->
                    <div class="col-sm-4 text-right">
                      IP: <?php echo $ip;?>
                    </div>
                  </div>                  

                </div>
              </div>
            </div>
          </div>

          <!--Comentarios-->
          <?php

          $commentQuery = $con->_getComment("SELECT * FROM comentarios WHERE idProcess = '$processoID' ORDER BY data ASC ");
          if (!$commentQuery) {
            # code...

          }else{
            while($commentInfo = mysqli_fetch_array($commentQuery)){
              $commentUserID = $commentInfo['userID'];
              $commentTexto = $commentInfo['comentario'];
              $commentData = $commentInfo['data'];
              $commentHora = $commentInfo['hora'];
              $commentIP = $commentInfo['ip'];
              
              if ($commentInfo == 0) {
              }else{
                $commentUserNick = $con->_getNickName($commentUserID);
                $colorComment = $con->_getIsInvolvedColor($commentUserID, $processoID);
                $posComment = $con->_getIsInvolvedPosicao($commentUserID, $processoID);
              ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header bg-<?php echo $colorComment;?>">
                        <h5 class="card-title ">Pronunciamento de <?php echo $commentUserNick;?> (<?php echo $posComment;?>)</h5>
                        <div class="card-tools">
                        <?php if($commentUserID == $userID || $isAdmin){?>
                          <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                              <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                              <?php if($commentUserID == $userID){?>
                              <a href="#" class="dropdown-item" style="color: #000 !important;">Editar</a>
                              <?php }else{?>
                              <a href="../dist/action/deleteComment.php?" class="dropdown-item" style="color: #000 !important;">Excluir</a>
                              <?php }?>
                            </div>
                          </div>                      

                        <?php }?>
                          <button type="button" class="btn btn-tool" data-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-12 ml-auto mr-auto">
                            <?php

                            //Aguardando Juri
                            if ($commentTexto == '27c47b28fb5f4545bda5d276ab55d84ccf9cc790581904c72fecdb4d623ce049396a14ab206e2b44e03c4e00393e948cce36a6b0f0d7489cb46d944b33ad51c8') {
                              echo "<div class='alert alert-info alert-dismissible'><h5><i class='icon fas fa-exclamation'></i>Um Juri foi solicitado neste processo, aguarde!</h5></div>";

                            }elseif ($commentTexto == '6d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf4') {
                              echo "<div class='alert alert-info alert-dismissible'><h5><i class='icon fas fa-exclamation'></i>O acusado tem 24 horas para se pronunciar, caso contrário este processo será aceito.</h5></div>";

                            //Processo Aprovado
                            }elseif ($commentTexto == '9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8') {
                              echo "<div class='alert alert-info alert-dismissible'><h5><i class='icon fas fa-balance-scale'></i>O acusado foi condenado à cadeia administrativa.</h5></div>";
                            }else{
                              echo $commentTexto;                          
                            }?>
                          </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="row" style="font-size: 10px">
                          <!--Data + Editado-->
                          <div class="col-sm-8">
                            Comentário feito no dia <?php echo $commentData;?> às <?php echo $commentHora;?>
                          </div>
                          <!--IP-->
                          <div class="col-sm-4 text-right">
                            <?php if($isAdmin){?>
                            IP: <?php echo $commentIP;?>
                            <?php }?>
                          </div>
                        </div>                  

                      </div>
                    </div>
                  </div>
                </div>
              <?php 
              }
            }
          }

          ?>
          <div class="row">
            <div class="col-lg-12 ">
              <div class="card-header bg-gradient-secondary">
                <h6 class="card-title">Comentar</h6>
              </div>
              <div class="card-body mb-3" style="padding: 0 !important">
                <form method="post" action="../dist/action/comentar.php?id=<?php echo $processoID;?>">
                  <textarea id="comentario" name="comentario" class="textarea" placeholder="Digite seu comentario aqui!" required style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if($access == 0){echo "Este processo foi trancado.";}elseif($status == 'Apurado'){echo "Este processo foi finalizado.";}?></textarea>
                    <input type="submit" class="btn btn-block bg-gradient-secondary btn" style="max-width: 200px;" value="Enviar">
                </form>
              </div>
            </div>
          </div>
        <?php 
        }
        ?>
        
      </section>
    </div>
    <?php include "../includes/footer.php"; ?> 



    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <?php if($isAdmin){?>
        <div class="modal fade" id="moveModal">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Mover Processo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="moveForm" action="=<?php echo $processoID;?>">
                <div class="modal-body">
                  <p>Selecione a area para onde deseja mover</p>
                    <select class="form-control" name="areaProcess" id="areaProcess" form="moveForm" required>
                      <option value="Player">Player</option>
                      <option value="Lider/Sublideres">Lider/Sublideres</option>
                      <option value="Cheater">Cheater</option>
                      <option value="Caloteiro">Caloteiro</option>
                      <option value="Staff Server">Staff Server</option>
                      <option value="Staff TS3">Staff TS3</option>
                      <option value="Staff Fórum">Staff Fórum</option>
                      <option value="Juiz">Juiz</option>
                    </select>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button type="button"  onclick="sendMove(<?php echo $processoID;?>);" class="btn btn-primary">Enviar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal fade" id="aprovarModalLobby">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Aprovar Processo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Selecione o metodo que será aplicado a punição!</p>
                <div class="row mb-4">
                  <div class="col-5 m-auto text-center rounded">
                    <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#minutosModal">Punição Minutos</button>
                  </div>

                  <div class="col-5 m-auto text-center rounded">
                    <button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-target="#gravidadeModal">Punição Gravidade</button>
                  </div>
                </div>                
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="gravidadeModal">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Punição por Gravidade</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="moveForm" method="post" action="../dist/action/addPunish.php">
                <div class="modal-body">
                  <input type="hidden" name="tipo" value="gravidade">
                  <input type="hidden" name="id" value="<?php echo $processoID; ?>">
                  <p>Selecione a gravidade de prisão em que o mesmo receberá.</p>
                  <input type="number" class="form-control"  name="gravidade" value="1">

                  <p>Selecione a quuantidade de aviso que o mesmo tomará, caso seja nenhum deixe 0.</p>
                  <input type="number" class="form-control"  name="avisos" value="0">
                </div>                             
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <input type="submit" class="btn btn-primary" value="Aplicar">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal fade" id="minutosModal">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Punição por Minutos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="Form" method="post" action="../dist/action/addPunish.php">
                <div class="modal-body text-center">
                  <input type="hidden" name="tipo" value="minutos">
                  <input type="hidden" name="id" value="<?php echo $processoID; ?>">
                  <p>Selecione o tempo de prisão em minutos que o mesmo receberá.</p>
                  <input type="number" class="form-control"  name="minutos" value="30">
                  <p>Selecione a quuantidade de aviso que o mesmo tomará,<br> caso seja nenhum deixe 0.</p>
                  <input type="number" class="form-control"  name="avisos" value="0">
                </div>                             
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <input type="submit" class="btn btn-primary" value="Aplicar">
                </div>
              </form>
            </div>
          </div>
        </div>
    <?php }?>
  </div>


  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../plugins/fastclick/fastclick.js"></script>
  <script src="../dist/js/adminlte.min.js"></script>
  <script src="../dist/js/demo.js"></script>


  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <script>
    $(function () {
      $('.textarea').summernote()
    })


    <?php 
    if($permInfo['getUseCode'] == 0){
      ?>
    $('.textarea').summernote({
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link']],
        ['view', ['fullscreen'], ['code']]
      ]
    });
    <?php }?>


    <?php 

    if($access == 0 || $status == 'Apurado'){
      ?>
      $('.textarea').summernote('disable');
      <?php

    }



    ?>
  </script>
  <script>
    function sendMove(id) {
      area = document.getElementById("areaProcess").value;
      window.location.href = "../dist/action/moderationAction.php?action=move&id="+id+"&area="+area; 

    }

    function aprovedProcess(id){
      window.location.href = "../dist/action/moderationAction.php?action=approvedprocess&id="+id;
    }

    function deletar(id){
      if (confirm("Você tem certeza que deseja deletar o processo?")) {        
        window.location.href = "../dist/action/moderationAction.php?action=delete&id="+id;
      }
    }

    function restore(id){
      if (confirm("Você tem certeza que deseja restaurar o processo?")) {        
        window.location.href = "../dist/action/moderationAction.php?action=restore&id="+id;
      }
    }

    function requestJuri(id){
      if (confirm("Você tem certeza que deseja solicitar um juri para o processo?")) {        
        window.location.href = "../dist/action/moderationAction.php?action=requestJuri&id="+id;
      }
    }

  </script>
  </body>
</html>