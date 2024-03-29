  <!-- Sidebar -->
  <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a style="background-color:white;" class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-icon">
              <img src="<?= base_url('assets/ruang-admin'); ?>/img/logo/Tj.png">
          </div>
          <div class="sidebar-brand-text mx-3 text-dark">TJ MART</div>
      </a>

      <li class="nav-item">
          <a class="nav-link" href="<?= base_url('Halaman_utama'); ?>">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Halaman Utama</span></a>
      </li>
      <hr class="sidebar-divider">
      <?php
        if ($this->session->userdata('hak_pengguna') == 'administrator') { ?>
          <div class="sidebar-heading">
              Data Master
          </div>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
                  <i class="far fa-fw fa-window-maximize"></i>
                  <span>Barang</span>
              </a>
              <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="<?= base_url('Jenis_barang'); ?>">Jenis barang</a>
                      <a class="collapse-item" href="<?= base_url('Satuan'); ?>">Satuan</a>
                      <a class="collapse-item" href="<?= base_url('Stok_barang'); ?>">Stok barang</a>
                  </div>
              </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Pemasok'); ?>">
                  <i class="fas fa-fw fa-truck-moving"></i>
                  <span>Supplier</span>
              </a>
          </li>
          <hr class="sidebar-divider">
          <div class="sidebar-heading">
              Transaksi
          </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Barang_masuk'); ?>">
                  <i class="fas fa-fw fa-arrow-right"></i>
                  <span>Barang Masuk</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Barang_keluar'); ?>">
                  <i class="fas fa-fw fa-arrow-left"></i>
                  <span>Barang Keluar</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Keluar_barang'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Barang kadaluarsa</span>
              </a>
          </li>
          <hr class="sidebar-divider">
          <div class="sidebar-heading">
              Pengguna
          </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Pengguna'); ?>">
                  <i class="fas fa-fw fa-users"></i>
                  <span>Pengguna</span>
              </a>
          </li>
      <?php
        }

        if ($this->session->userdata('hak_pengguna') == 'asisten manajer') { ?>
          <div class="sidebar-heading">
              Transaksi
          </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Permintaan'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Permintaan</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Laporan/index'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Laporan</span>
              </a>
          </li>
      <?php
        }
        ?>


      <?php
        if ($this->session->userdata('hak_pengguna') == 'staf gudang') { ?>
          <div class="sidebar-heading">
              Data Master
          </div>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
                  <i class="far fa-fw fa-window-maximize"></i>
                  <span>Barang</span>
              </a>
              <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="<?= base_url('Jenis_barang'); ?>">Jenis barang</a>
                      <a class="collapse-item" href="<?= base_url('Satuan'); ?>">Satuan</a>
                      <a class="collapse-item" href="<?= base_url('Stok_barang'); ?>">Stok barang</a>
                  </div>
              </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Pemasok'); ?>">
                  <i class="fas fa-fw fa-truck-moving"></i>
                  <span>Supplier</span>
              </a>
          </li>
          <hr class="sidebar-divider">
          <div class="sidebar-heading">
              Transaksi
          </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Barang_masuk'); ?>">
                  <i class="fas fa-fw fa-arrow-right"></i>
                  <span>Barang Masuk</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Barang_keluar'); ?>">
                  <i class="fas fa-fw fa-arrow-left"></i>
                  <span>Barang Keluar</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Permintaan'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Permintaan</span>
              </a>
          </li>
      <?php
        } elseif ($this->session->userdata('hak_pengguna') == 'kepala gudang') { ?>
          <div class="sidebar-heading">
              Data Master
          </div>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
                  <i class="far fa-fw fa-window-maximize"></i>
                  <span>Barang</span>
              </a>
              <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="<?= base_url('Jenis_barang'); ?>">Jenis barang</a>
                      <a class="collapse-item" href="<?= base_url('Satuan'); ?>">Satuan</a>
                      <a class="collapse-item" href="<?= base_url('Stok_barang'); ?>">Stok barang</a>
                  </div>
              </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Pemasok'); ?>">
                  <i class="fas fa-fw fa-truck-moving"></i>
                  <span>Supplier</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Barang'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Data Barang</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Pengadaan'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Pengadaan</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Monitoring_kadaluarsa'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Monitoring Kadaluarsa</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Retur_barang'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Retur Barang</span>
              </a>
          </li>
          <hr class="sidebar-divider">
          <div class="sidebar-heading">
              Transaksi
          </div>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Barang_masuk'); ?>">
                  <i class="fas fa-fw fa-arrow-right"></i>
                  <span>Barang Masuk</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Barang_keluar'); ?>">
                  <i class="fas fa-fw fa-arrow-left"></i>
                  <span>Barang Keluar</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Permintaan'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Permintaan</span>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?= base_url('Keluar_barang'); ?>">
                  <i class="fas fa-fw fa-cube"></i>
                  <span>Barang Kadaluarsa</span>
              </a>
          </li>

      <?php
        }

        ?>



  </ul>

  <!-- Sidebar -->
  <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">