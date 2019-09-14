  <?php
  $painelName = "PlayStart";
  $version = "LITE";


  $qntAndamento = $con->_query("SELECT * FROM processos WHERE status = 'Em andamento'");
  $qntAndamento = mysqli_num_rows($qntAndamento);
  $qntMeus = $con->_query("SELECT * FROM processos WHERE autorID = '$userID' AND status = 'Aguardando' AND deletado = 0 OR autorID = '$userID' AND status = 'Em andamento' AND deletado = 0 OR reuID = '$userID' AND status = 'Aguardando' AND deletado = 0 OR reuID = '$userID' AND status = 'Em andamento' AND deletado = 0");
  $qntMeus = mysqli_num_rows($qntMeus);
  $qntApurados = $con->_quantidadeInqueritosApuradosTotal();
  $qntAguardando = $con->_query("SELECT * FROM processos WHERE status = 'Aguardando' AND deletado = 0");
  $qntAguardando = mysqli_num_rows($qntAguardando);
  $qntDeletados = $con->_query("SELECT * FROM processos WHERE deletado = 1");
  $qntDeletados = mysqli_num_rows($qntDeletados);
  $qntPunicaoMinutos = $con->_quantidadePunicoesMinutos();
  $qntPunicaoGravidade = $con->_quantidadePunicoesGravidade();

  $valorProcess1 = false;
  $valorProcess2 = 'none';
  if(isset($processoPage)){
    if($processoPage == true){$valorProcess1 = 'menu-open';$valorProcess2 = 'block';}
  }
  ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $linkhost;?>index.php" class="brand-link">
      <img src="../dist/img/logo.png"
           alt="BPS Logo"
           class="brand-image"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $painelName;?>
        <sup>
          <?php echo $version;?>            
        </sup>
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['userConectado'];?></a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">Ouvidoria Geral</li>
          <li class="nav-item has-treeview <?php echo $valorProcess1;?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folders"></i>
              <p>
                Processos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display:<?php echo $valorProcess2;?>">
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>processos/abrirprocesso.php" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Abrir Processo</p>
                  <span class="right badge badge-danger">NOVO</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>processos/index.php?page=meusprocessos" class="nav-link">
                  <i class="fas fa-folder nav-icon"></i>
                  <p>Meus Processos</p>
                  <span class="badge badge-secondary right"><?php echo $qntMeus;?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>processos/index.php?page=aguardando" class="nav-link">
                  <i class="far fa-clock nav-icon"></i>
                  <p>Aguardando</p>
                  <span class="badge badge-info right"><?php echo $qntAguardando;?></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>processos/index.php?page=andamento" class="nav-link">
                  <i class="far fa-sync-alt nav-icon"></i>
                  <p>Em andamento</p>
                  <span class="badge badge-warning right"><?php echo $qntAndamento;?></span>
                </a>
              </li>
              <li class="nav-item border-bottom-1">
                <a href="<?php echo $linkhost;?>processos/index.php?page=apurado" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Apurados</p>
                  <span class="badge badge-success right"><?php echo $qntApurados;?></span>
                </a>
              </li>
              <?php if($isAdmin){?>
              <hr style="border-top: 1px solid #4f5962;">
              <li class="nav-item border-bottom-1">
                <a href="<?php echo $linkhost;?>processos/deletados.php" class="nav-link">
                  <i class="far fa-trash nav-icon"></i>
                  <p>Deletado</p>
                  <span class="badge badge-danger right"><?php echo $qntDeletados;?></span>
                </a>
              </li>
              <li class="nav-item border-bottom-1">
                <a href="<?php echo $linkhost;?>processos/punicao.php" class="nav-link">
                  <i class="far fa-gavel nav-icon"></i>
                  <p>Punições</p>
                  <span class="badge badge-danger right mr-1" title="Punições em Gravidade"><?php echo $qntPunicaoGravidade;?></span><span class="badge badge-warning right" title="Punições em Minutos"><?php echo $qntPunicaoMinutos;?></span>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li><?php /*
          <li class="nav-header">Utilitários</li>          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-store"></i>
              <p>
                Loja
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>cash/index.php?area=comprar" class="nav-link">
                  <i class="far fa-shopping-cart nav-icon"></i>
                  <p>Produtos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>cash/index.php?area=minhas-compras" class="nav-link">
                  <i class="far fa-receipt nav-icon"></i>
                  <p>Minhas Compras</p>
                </a>
              </li>
            </ul>
          </li>*/?>
        <?php if($isAdmin){
          $permInfo = $con->_getPerm($cargo);?>
          <li class="nav-header">Painel Administrativo</li>   
          <?php 
          if($permInfo['getCreateReason'] == 1 || $permInfo['getRemoveReason'] == 1 || $permInfo['getCreateRole'] == 1 || $permInfo['getDeleteRole'] == 1 || $permInfo['getGiveAdmin'] == 1 || $permInfo['getRemoveAdmin'] == 1){
          ?>   
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-cog"></i>
              <p>
                Configurações
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php 
              if($permInfo['getCreateReason'] == 1 || $permInfo['getRemoveReason'] == 1){
              ?>
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>administrativo/motivos.php" class="nav-link">
                  <i class="far fa-book nav-icon"></i>
                  <p>Config. Motivos</p>
                </a>
              </li>
              <?php
              }
              if($permInfo['getCreateRole'] == 1 || $permInfo['getDeleteRole'] == 1){
              ?>              
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>administrativo/cargo.php" class="nav-link">
                  <i class="far fa-user-cog nav-icon"></i>
                  <p>Criar/Editar Cargos</p>
                </a>
              </li>
              <?php
              }
              if($permInfo['getGiveAdmin'] == 1 || $permInfo['getRemoveAdmin'] == 1){
              ?>                
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>administrativo/administradores.php" class="nav-link">
                  <i class="far fa-users nav-icon"></i>
                  <p>Gerenciar Usuários</p>
                </a>
              </li>
              <?php              
              }
              if($permInfo['getGiveAdmin'] == 1 || $permInfo['getRemoveAdmin'] == 1){
              ?>                
              <li class="nav-item">
                <a href="<?php echo $linkhost;?>administrativo/banidos.php" class="nav-link">
                  <i class="far fa-user-alt-slash nav-icon"></i>
                  <p>Gerenciar Banidos</p>
                </a>
              </li>
              <?php
              }
              ?>
            </ul>
          </li> 
          <?php 
          }
          if($permInfo['getViewLogs'] == 1){
          ?>
          <li class="nav-item">
            <a href="<?php echo $linkhost;?>administrativo/logs.php" class="nav-link">
              <i class="far fa-clipboard-list nav-icon"></i>
              <p>Logs</p>
            </a>
          </li>      
        <?php }
         } ?>
        </ul>
      </nav>
    </div>
  </aside>