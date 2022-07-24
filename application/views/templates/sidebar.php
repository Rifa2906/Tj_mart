  <!-- Sidebar -->
  <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a style="background-color:white;" class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-icon">
              <img src="<?= base_url('assets/ruang-admin'); ?>/img/logo/Tj.png">
          </div>
          <div class="sidebar-brand-text mx-3 text-dark">TJ MART</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
          <a class="nav-link" href="<?= base_url('Dashboard'); ?>">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Halaman Utama</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
          Features
      </div>
      <li class="nav-item">
          <a class="nav-link" href="<?= base_url('User'); ?>">
              <i class="fas fa-fw fa-user"></i>
              <span>Data Pengguna</span>
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
              <i class="far fa-fw fa-window-maximize"></i>
              <span>Barang</span>
          </a>
          <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="alerts.html">Barang masuk</a>
                  <a class="collapse-item" href="buttons.html">Barang keluar</a>
              </div>
          </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="ui-colors.html">
              <i class="fas fa-fw fa-palette"></i>
              <span>Data Supplier</span>
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="ui-colors.html">
              <i class="fas fa-fw fa-palette"></i>
              <span>Pengadaan Barang</span>
          </a>
      </li>
  </ul>
  <!-- Sidebar -->
  <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">