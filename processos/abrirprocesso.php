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

$user_result = $con->_query("SELECT * FROM usuarios");
if(!isset($_SESSION['userConectado'])){
  header("Location: ../index.php");
}

$area = null;
if(isset($_POST['areaProcess'])){
  $area = $_POST['areaProcess'];
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

              <h1>Abrir Processo</h1>

            </div>

            <div class="col-sm-6">

              <ol class="breadcrumb float-sm-right">

                <li class="breadcrumb-item"><a href="#">Inicio</a></li>

                <li class="breadcrumb-item active">Abrir Processo</li>

              </ol>

            </div>

          </div>

        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
          <div class="col-lg-8 mr-auto ml-auto">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Olá <?php echo $userConectado;?> tudo bom?</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if($area == null){?>
                  <form role="form" method="post" action="abrirprocesso.php" id="formProcess">
                    <div class="form-group">
                      <label>Selecione a área do processo</label>
                      <select class="form-control" name="areaProcess" id="areaProcess" form="formProcess" required>
                        <option value="Player">Player</option>
                        <option value="Lider/Sublideres">Lider/Sublideres</option>
                        <option value="Cheater">Cheater</option>
                        <option value="Caloteiro">Caloteiro</option>
                        <option value="Staff Server">Staff Server</option>
                        <option value="Staff Discord">Staff Discord</option>
                        <option value="Staff Fórum">Staff Fórum</option>
                        <option value="Juiz">Juiz</option>
                      </select>
                      <input type="submit" value="Próximo" class="btn btn-block bg-gradient-danger mt-3" style="width: 150px; float: right;">
                    </div>                  
                  </form>
                <?php }else{?>
                  <form role="form" id="formProcess" action="../dist/action/createProcess.php" method="post">
                  <!-- select -->
                  <input type="hidden" name="areaProcess" value="<?php echo $area;?>">
                    <label>Autor</label>
                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-user-alt"></i>
                            </span>
                          </div>
                            <input type="text" name="autorNick" class="form-control" placeholder="Nick in-game do Autor" value="<?php echo $userConectado;?>" disabled>
                        </div>
                        <!-- /input-group -->
                      </div>
                      <!-- /.col-lg-6 -->
                      <div class="col-lg-6">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-landmark"></i></span>
                          </div>                  
                            <select class="form-control" name="autorOrg" id="autorOrg" form="formProcess" required>
                                <option value="Civil">Civil</option>
                                <option value="San News">San News</option>
                                <optgroup label="Governamentais (8)">
                                  <option value="Policia Militar">Polícia Militar</option>  
                                  <option value="ROTA">ROTA</option>  
                                  <option value="Exercito">Exército</option>  
                                  <option value="Governo">Governo</option>  
                                  <option value="Policia Federal">Polícia Federal</option>  
                                  <option value="Policia Rodoviaria Federal">Polícia Rodoviária Federal</option>  
                                  <option value="Polícia Civil">Polícia Civil</option> 
                                </optgroup>   
                                <optgroup label="Gangster (6)">
                                  <option value="Los Aztecas">Los Aztecas</option>  
                                  <option value="Groove Street">Groove Street</option>  
                                  <option value="Ballas">Ballas</option>  
                                  <option value="Los Vagos">Los Vagos</option>  
                                  <option value="Seville Boulevard">Seville Boulevard</option>  
                                  <option value="Crips">Crips</option>  
                                </optgroup>   
                                <optgroup label="Assassinas (2)">
                                  <option value="Hitmans">Hitmans</option>  
                                  <option value="The Triad">The Triad</option>
                                </optgroup> 
                                <optgroup label="Mafiosas (3)">
                                  <option value="Máfia Bratva">Máfia Bratva</option>  
                                  <option value="Máfia Yakuza">Máfia Yakuza</option>
                                  <option value="Máfia Cosa Nostra">Máfia Cosa Nostra</option>
                                </optgroup> 
                                <optgroup label="Terroristas (3)">
                                  <option value="As FARC">As FARC</option>  
                                  <option value="Estado Islamico">Estado Islâmico</option>  
                                  <option value="Guerrilheiros Israelitas">Guerrilheiros Israelitas</option>  
                                </optgroup> 
                                <optgroup label="Mercenárias (2)">
                                  <option value="Sons Of Anarchy">Sons Of Anarchy</option>
                                  <option value="Warlocks">Warlocks</option>  
                                </optgroup>
                              </select>
                        </div>
                        <!-- /input-group -->
                      </div>
                      <!-- /.col-lg-6 -->
                    </div>
                    <label>Réu</label>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-user-alt"></i>
                            </span>
                          </div>
                            <input name="reuNick" type="text" class="form-control" placeholder="Nick in-game do réu"required>
                        </div>
                        <!-- /input-group -->
                      </div>
                      <!-- /.col-lg-6 -->
                      <div class="col-lg-6">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="fas fa-landmark"></i>
                            </span>
                          </div>
                            <?php if($area == 'Player' || $area == 'Cheater' || $area == 'Caloteiro' || $area == 'Lider/Sublideres'){?>                                   
                            <select class="form-control" name="reuOrg" id="reuOrg" form="formProcess" required>
                                <option value="Civil">Civil</option>
                                <option value="San News">San News</option>
                                <optgroup label="Governamentais (8)">
                                  <option value="Policia Militar">Polícia Militar</option>  
                                  <option value="ROTA">ROTA</option>  
                                  <option value="Exercito">Exército</option>  
                                  <option value="Governo">Governo</option>  
                                  <option value="Policia Federal">Polícia Federal</option>  
                                  <option value="Policia Rodoviaria Federal">Polícia Rodoviária Federal</option>  
                                  <option value="Polícia Civil">Polícia Civil</option> 
                                </optgroup>   
                                <optgroup label="Gangster (6)">
                                  <option value="Los Aztecas">Los Aztecas</option>  
                                  <option value="Groove Street">Groove Street</option>  
                                  <option value="Ballas">Ballas</option>  
                                  <option value="Los Vagos">Los Vagos</option>  
                                  <option value="Seville Boulevard">Seville Boulevard</option>  
                                  <option value="Crips">Crips</option>  
                                </optgroup>   
                                <optgroup label="Assassinas (2)">
                                  <option value="Hitmans">Hitmans</option>  
                                  <option value="The Triad">The Triad</option>
                                </optgroup> 
                                <optgroup label="Mafiosas (3)">
                                  <option value="Máfia Bratva">Máfia Bratva</option>  
                                  <option value="Máfia Yakuza">Máfia Yakuza</option>
                                  <option value="Máfia Cosa Nostra">Máfia Cosa Nostra</option>
                                </optgroup> 
                                <optgroup label="Terroristas (3)">
                                  <option value="As FARC">As FARC</option>  
                                  <option value="Estado Islamico">Estado Islâmico</option>  
                                  <option value="Guerrilheiros Israelitas">Guerrilheiros Israelitas</option>  
                                </optgroup> 
                                <optgroup label="Mercenárias (2)">
                                  <option value="Sons Of Anarchy">Sons Of Anarchy</option>
                                  <option value="Warlocks">Warlocks</option>  
                                </optgroup>
                              </select>
                            <?php }elseif($area == 'Staff Server'){?>                                       
                            <select class="form-control" name="reuOrg" id="reuOrg" form="formProcess" required>
                                <option value="Helper">Helper</option>
                                <option value="Estágiario">Estágiario</option>
                                <option value="Moderador">Moderador</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Encarregado">Encarregado</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Diretor">Diretor</option>
                                <option value="Dono">Dono</option>
                                <option value="Fundador">Fundador</option>
                              </select>
                            <?php }elseif($area == 'Staff TS3'){?>                                       
                            <select class="form-control" name="reuOrg" id="reuOrg" form="formProcess" required>
                                <option value="Moderador Estagiário TS">Moderador Estagiário TS</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Moderador TS">Moderador TS</option>
                                <option value="Moderador TS Sênior">Moderador TS Sênior</option>
                                <option value="Administrador TS">Administrador TS</option>
                                <option value="Administrador TS Sênior">Administrador TS Sênior</option>
                                <option value="Supervisor Administração TS">Supervisor Administração TS</option>
                                <option value="Diretor Administração TS">Diretor Administração TS</option>
                              </select>  
                            <?php }elseif($area == 'Staff Fórum'){?>                                       
                              <select class="form-control" name="reuOrg" id="reuOrg" form="formProcess" required>
                                <option value="Moderador Estágiario">Moderador Estagiário</option>
                                <option value="Moderador">Moderador</option>
                                <option value="Moderador Global">Moderador Global</option>
                                <option value="Administrador Fórum">Administrador Fórum</option>
                                <option value="Sub Responsável Fórum">Sub Responsável Fórum</option>
                                <option value="Responsável Fórum">Responsável Fórum</option>
                              </select>       
                            <?php }elseif($area == 'Juiz'){?>                                       
                              <select class="form-control" name="reuOrg" id="reuOrg" form="formProcess" required>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Juiz Substituto">Juiz Substituto</option>
                                <option value="Juiz">Juiz</option>
                                <option value="Corregedor">Corregedor</option>
                                <option value="Desembargador">Desembargador</option>
                              </select>
                            <?php } ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group"><!--EMBREVE
                      <a href="#"><i class="fas fa-plus"></i>  Adicionar mais réu</a>-->
                    </div>
                    <div class="form-group">
                      <label>Provas</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-globe-americas"></i>
                            </span>
                          </div>
                            <input name="provas" type="url" class="form-control" placeholder="https://www.imgur.com" required>
                        </div><!--EMBREVE
                      <a href="#"><i class="fas fa-plus"></i>  Adicionar mais provas</a>-->
                    </div>
                    <div class="form-group">
                      <label>Selecione o Motivo</label>
                      <select class="form-control" name="motivo" id="motivo" form="formProcess" required>
                        <?php
                          $motivos_consulta = $con->_query("SELECT * FROM motivo");
                          while ($motivos_lista = mysqli_fetch_array($motivos_consulta)) {
                        ?>
                          <option value="<?php echo $motivos_lista['motivoValue'];?>"><?php echo $motivos_lista['motivo'];?></option>
                        <?php }?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Descrição</label>
                      <div class="mb-3">
                        <textarea id="descricao" name="descricao" class="textarea" placeholder="Descreva como foi o ocorrido" required

                                    style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                        </div>
                        </p>
                    </div>
                    <input type="submit" value="Enviar" class="btn btn-block bg-gradient-danger" style="width: 150px; float: right;">
                  </form>
                <?php }?>
              </div>
              <!-- /.card-body -->
            </div>
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
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <script>
    $(function () {
      $('.textarea').summernote()
    })
    $('.textarea').summernote({
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link']],
        ['view', ['fullscreen']]
      ]
    });

    $("#areaProcess").change(function(){
      var area = $(this).val();
      if (area == 'Player') {
        $("#reuOrg").removeAttr('disabled');
        $("#reuOrg1").prop("disabled", false);
        $("#reuOrg2").prop("disabled", false);
        $("#reuOrg3").prop("disabled", false);
        $("#reuOrg4").prop("disabled", false);
        $("#reuOrg").css("display", "block");
        $("#reuOrg1").css("display", "none");
        $("#reuOrg2").css("display", "none");
        $("#reuOrg3").css("display", "none");
        $("#reuOrg4").css("display", "none");
        $("#reuOrg option:selected").attr('disabled','disabled')
        .siblings().removeAttr('disabled');
        $("#reuOrg1 option:selected").attr('disabled','disabled')
        .siblings().removeAttr('disabled');
        $("#reuOrg2 option:selected").attr('disabled','disabled')
        .siblings().removeAttr('disabled');
        $("#reuOrg3 option:selected").attr('disabled','disabled')
        .siblings().removeAttr('disabled');
        $("#reuOrg4 option:selected").attr('disabled','disabled')
        .siblings().removeAttr('disabled');
      }
      else if (area == 'Lider/Sublideres') {
        $("#reuOrg").removeAttr('disabled');
        $("#reuOrg1").prop("disabled", false);
        $("#reuOrg2").prop("disabled", false);
        $("#reuOrg3").prop("disabled", false);
        $("#reuOrg4").prop("disabled", false);
        $("#reuOrg").css("display", "block");
        $("#reuOrg1").css("display", "none");
        $("#reuOrg2").css("display", "none");
        $("#reuOrg3").css("display", "none");
        $("#reuOrg4").css("display", "none");
      }
      else if (area == 'Cheater') {
        $("#reuOrg").removeAttr('disabled');
        $("#reuOrg1").prop("disabled", false);
        $("#reuOrg2").prop("disabled", false);
        $("#reuOrg3").prop("disabled", false);
        $("#reuOrg4").prop("disabled", false);
        $("#reuOrg").css("display", "block");
        $("#reuOrg1").css("display", "none");
        $("#reuOrg2").css("display", "none");
        $("#reuOrg3").css("display", "none");
        $("#reuOrg4").css("display", "none");
      }
      else if (area == 'Caloteiro') {
        $("#reuOrg").removeAttr('disabled');
        $("#reuOrg1").prop("disabled", false);
        $("#reuOrg2").prop("disabled", false);
        $("#reuOrg3").prop("disabled", false);
        $("#reuOrg4").prop("disabled", false);
        $("#reuOrg").css("display", "block");
        $("#reuOrg1").css("display", "none");
        $("#reuOrg2").css("display", "none");
        $("#reuOrg3").css("display", "none");
        $("#reuOrg4").css("display", "none");
      }
      else if (area == 'Staff Server') {
        $("#reuOrg").prop("disabled", false);
        $("#reuOrg1").removeAttr('disabled');
        $("#reuOrg2").prop("disabled", false);
        $("#reuOrg3").prop("disabled", false);
        $("#reuOrg4").prop("disabled", false);
        $("#reuOrg").css("display", "none");
        $("#reuOrg1").css("display", "block");
        $("#reuOrg2").css("display", "none");
        $("#reuOrg3").css("display", "none");
        $("#reuOrg4").css("display", "none");
      }
      else if (area == 'Staff TS3') {
        $("#reuOrg").prop("disabled", false);
        $("#reuOrg1").prop("disabled", false);
        $("#reuOrg2").removeAttr('disabled');
        $("#reuOrg3").prop("disabled", false);
        $("#reuOrg4").prop("disabled", false);
        $("#reuOrg").css("display", "none");
        $("#reuOrg1").css("display", "none");
        $("#reuOrg2").css("display", "block");
        $("#reuOrg3").css("display", "none");
        $("#reuOrg4").css("display", "none");
      }
      else if (area == 'Staff Fórum') {
        $("#reuOrg").prop("disabled", false);
        $("#reuOrg1").prop("disabled", false);
        $("#reuOrg2").prop("disabled", false);
        $("#reuOrg3").removeAttr('disabled');
        $("#reuOrg4").prop("disabled", false);
        $("#reuOrg").css("display", "none");
        $("#reuOrg1").css("display", "none");
        $("#reuOrg2").css("display", "none");
        $("#reuOrg3").css("display", "block");
        $("#reuOrg4").css("display", "none");
      }
      else if (area == 'Juiz') {
        $("#reuOrg").prop("disabled", false);
        $("#reuOrg1").prop("disabled", false);
        $("#reuOrg2").prop("disabled", false);
        $("#reuOrg3").prop("disabled", false);
        $("#reuOrg4").removeAttr('disabled');
        $("#reuOrg").css("display", "none");
        $("#reuOrg1").css("display", "none");
        $("#reuOrg2").css("display", "none");
        $("#reuOrg3").css("display", "none");
        $("#reuOrg4").css("display", "block");
      }
    });
  </script>
  </body>
</html>