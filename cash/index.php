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
    $area = "";
    if (isset($_GET['area'])) {
      $area = $_GET['area'];
    }
if($isAdmin == false){  
    $con->_addLog($userID, "Tentou acessar uma área restrita para administradores.", 'Punição');
    header("Location: ../../index.php");
}
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PlayStart - Loja</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.9.0/css/pro.min.css">

  <!-- Ionicons -->
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/product.min.css">
  <link rel="stylesheet" type="text/css" href="../dist/owl/dist/ow.carousel.min.js">
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

<?php

if ($area == "minhas-compras") {

?>

  <!-- Minhas Compras -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loja PlayStart</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Minhas Compras</li>
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
          <h3 class="card-title text-center">Minhas Compras</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover"> 
                    <tr>
                      <th>ID</th>
                      <th>Data da Compra</th>
                      <th>Data da Ativação</th>
                      <th>Status</th>
                      <th>Nick In-Game</th>
                      <th>Valor</th>
                      <th>Método</th>
                      <th>Opções</th>
                      <th>Ações</th>
                    </tr>                 	
		        	<?php
		        	$cashLista_consulta = $con->_query("SELECT * FROM cash WHERE idUser = '$userID'");
		        	while ($cashLista_informacao = mysqli_fetch_array($cashLista_consulta)) {
		        	?>
                    <tr>
                      <td><?php echo $cashLista_informacao['id']; ?></td>
                      <td><?php echo $cashLista_informacao['data']; ?></td>
                      <td><?php echo $cashLista_informacao['dataAti']; ?></td>
                      <td><?php echo $cashLista_informacao['status']; ?></td>
                      <td><?php echo $cashLista_informacao['nickServer']; ?></td>
                      <td><?php echo number_format($cashLista_informacao['valor'], 2, ',', '.');?></td>
                      <td><?php echo $cashLista_informacao['metodoPagamento']; ?></td>
                      <td><?php echo $cashLista_informacao['opcoes']; ?></td>
                      <td>
                        <a href="comprovantes/<?php echo $cashLista_informacao['id']; ?>.jpg" target="_blank" title="Ver Comprovante">
                          <i class="fas fa-receipt"></i>
                        </a>
                      </td>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php

}elseif($area == "comprar"){

?>
    <!-- Adquirir Cash -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Loja PlayStart</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Produtos</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <?php
          $categoriaQuery = $con->_query("SELECT categoria FROM categorias WHERE produtos > 0");
          while ($categoriaInfo = mysqli_fetch_array($categoriaQuery)) {
            $categoria = $categoriaInfo['categoria'];
        ?>
        <div class="card card-default color-palette-box">
          <div class="card-header">
            <h2 class="card-title"><?php echo $categoria;?></h2>
            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
          </div>

          <div class="card-body">
            <div class="row">
                  <?php
                  $productQuery = $con->_query("SELECT * FROM produtos WHERE categoria='$categoria' ORDER BY id DESC LIMIT 16");
                  while ($productInfo = mysqli_fetch_array($productQuery)) {
                    $val = number_format($productInfo['preco'], 2, ',', '.');
                    $valDes2 = (1 - $productInfo['desconto'] / 100) * $productInfo['preco'];
                    $valDes = number_format($valDes2, 2, ',', '.');                 

                    if($productInfo['vendas'] > 0)
                      $avaliacao = $productInfo['avaliacao'] / $productInfo['vendas'];
                    else
                      $avaliacao = 0;
                  ?>
                  <div class="col-lg-3 col-sm-6" style="margin-bottom: 25px;">
                      <div class="product-grid">
                          <div class="product-image">
                              <a href="#">
                                  <img class="pic-1" src="img/<?php echo $productInfo['img1'];?>.jpg">
                                  <img class="pic-2" src="img/<?php echo $productInfo['img2'];?>.jpg">
                              </a>
                              <ul class="social">
                                  <li><a href="" data-tip="Ver Produto"><i class="fa fa-search" style="top: 13px;position: relative;"></i></a></li>

                                  <?php if($productInfo['estoque'] > 0){
                                    ?>
                                  <li><a href="" data-tip="Adicionar ao Carrinho"><i class="fa fa-shopping-cart" style="top: 13px;position: relative;"></i></a></li> 
                                  <?php }?>
                              </ul>
                              <?php 


                              if($productInfo['alerta'] > 0){
                              $alertaID = $productInfo['alerta'];
                              $AlertaQuery = $con->_query("SELECT * FROM alertas WHERE id = '$alertaID'");
                              $alertaInfo = mysqli_fetch_assoc($AlertaQuery);
                              ?>
                              <span class="product-new-label bg-<?php echo $alertaInfo['cor']?>" style="text-transform: uppercase;"><?php echo $alertaInfo['texto']?></span>
                              <span class="product-new-label bg-<?php echo $alertaInfo['cor']?>" style="text-transform: uppercase;"><?php echo $alertaInfo['texto']?></span>
                              <?php }else{
                              } ?>
                              <?php if($productInfo['desconto'] > 0){?>
                              <span class="product-discount-label"><?php echo $productInfo['desconto'];?>% OFF</span>
                            <?php }?>
                          </div>
                          <ul class="rating">
                              <?php if($avaliacao >= 1 && $avaliacao < 2 ){?>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <?php }elseif($avaliacao >= 2 && $avaliacao < 3 ){?>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <?php }elseif($avaliacao >= 3 && $avaliacao < 4 ){?>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <?php }elseif($avaliacao >= 4 && $avaliacao < 5 ){?>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star disable"></li>
                              <?php }elseif($avaliacao == 5){?>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <li class="fa fa-star"></li>
                              <?php }else{?>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <li class="fa fa-star disable"></li>
                              <?php }?>
                          </ul>
                          <div class="product-content">
                              <h3 class="title"><a href="#"><?php echo $productInfo['nome'];?></a></h3>
                              <?php if($productInfo['desconto'] > 0){
                                ?>
                              <div class="price">R$ <?php echo $valDes;?>
                                  <span>R$ <?php echo $val;?></span>
                              </div>
                              <?php }else{?>
                              <div class="price">R$ <?php echo $val;?></div>            
                              <?php }?>
                              <?php if($productInfo['estoque'] > 0){
                                ?>
                              <a class="add-to-cart text-success">Em Estoque</a>  
                              <?php }else{?>
                              <a class="add-to-cart text-danger">Sem Estoque</a>          
                              <?php }?>
                          </div>
                      </div>
                  </div>
                  <?php
                  }?>
            </div>
          </div>
        </div>
        <?php
        }?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php

}elseif($area == "ativacao"){

?>
    <!-- Adquirir Cash -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Loja PlayStart</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Ativação da Compra</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

          <div class="col-lg-8 mr-auto ml-auto">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Olá <?php echo $userConectado;?> tudo bom?</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form">
                  <label>Sua Organização</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-landmark"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control" placeholder="Digite sua organização">
                    </div>
                  </div>
                  <label>Acusado(a)</label>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-user-alt"></i>
                          </span>
                        </div>
                          <input type="text" class="form-control" placeholder="Nick in-game do acusado">
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
                        <input type="text" class="form-control" placeholder="Organização/Cargo do Acusado">
                      </div>
                      <!-- /input-group -->
                    </div>
                    <!-- /.col-lg-6 -->
                  </div>
                  <div class="form-group">
                    <a href="#"><i class="fas fa-plus"></i>  Adicionar mais acusado</a>
                  </div>
                  <!-- /.row -->
                  <!-- text input -->
                  <div class="form-group">
                    <label>Provas</label>
                    <input type="text" class="form-control" placeholder="Insira o link contendo as provas">
                    <a href="#"><i class="fas fa-plus"></i>  Adicionar mais provas</a>
                  </div>
                  <div class="form-group">
                    <label>Descrição</label>
                    <textarea class="form-control" rows="3" placeholder="Por favor explique como foi o ocorrido"></textarea>
                  </div>
                  <!-- checkbox -->
                  <div class="form-group">
                    <label>Motivos</label>
                    <div class="row text-left">
                      <?php

                      $motivos_consulta = $con->_query("SELECT * FROM motivo");
                      while ($motivos_lista = mysqli_fetch_array($motivos_consulta)) {
                      ?>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?php echo $motivos_lista['motivoValue'];?>">
                            <label class="form-check-label"><?php echo $motivos_lista['motivo'];?></label>
                          </div>
                        </div>
                      </div>
                    <?php }?>
                    </div>
                  </div>

                  <!-- select -->
                  <div class="form-group">
                    <label>Selecione a área da denúncia</label>
                    <select class="form-control">
                      <option>Player</option>
                      <option>Lider/Sublideres</option>
                      <option>Cheater</option>
                      <option>Caloteiro</option>
                      <option>Staff Server</option>
                      <option>Staff TS3</option>
                      <option>Staff Fórum</option>
                      <option>Juiz</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customSwitch3">
                      <label class="custom-control-label" for="customSwitch3">Deseja receber notificações?</label>
                    </div>
                  </div>
                  <button type="button" class="btn btn-block bg-gradient-danger" style="width: 150px; float: right;">Enviar</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
      </section>
      <!-- /.content -->
    </div>
<?php

}else{
  echo "Pedi para o portuga fazer";
}
?>
<?php



?>

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
</body>
</html>