<?php


  $linkhost = "http://localhost/forum" . "/";
?>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Procurar processo..." aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">19</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">19 Notificações</span>
          <div class="dropdown-divider"></div>

          <!-- Notificação Player (Nova processo, ou postagem em processo) -->
          <a href="#" class="dropdown-item">
            <i class="far fa-newspaper mr-2"></i> 4 notif. de processo
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>

          <!-- Notificação Juri (Quando Citado ou solicitado) -->
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 4 novas solicitações
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>

          <!-- Notificação Staff (Novos processos disponiveis ou atualizados) -->
          <a href="#" class="dropdown-item">
            <i class="fas fa-file-alt mr-2"></i> 8 novos processos
            <span class="float-right text-muted text-sm">12 horas</span>
          </a>
          <div class="dropdown-divider"></div>


          <!-- Notificação Resp Juri (Novos processos disponiveis ou atualizados) -->
          <a href="#" class="dropdown-item">
            <i class="fas fa-redo mr-2"></i> 3 novas apelações
            <span class="float-right text-muted text-sm">2 dias</span>
          </a>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item dropdown-footer">Central de Notificações</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-cog"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $linkhost;?>/logout.php">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>