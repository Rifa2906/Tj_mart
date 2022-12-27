 <!-- TopBar -->
 <nav style="background-color: #cc0000;" class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
     <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
         <i class="fa fa-bars"></i>
     </button>
     <ul class="navbar-nav ml-auto">
         <?php
            if ($this->session->userdata('hak_pengguna') == 'asisten manajer') { ?>
             <li class="nav-item dropdown no-arrow mx-1">
                 <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fas fa-envelope fa-fw"></i>
                     <?php
                        $jumlah = $this->db->query("SELECT * FROM tb_permintaan WHERE status = 'Meminta persetujuan' ")->num_rows() ?>

                     <?php
                        if ($jumlah > 0) { ?>
                         <span class="badge badge-warning badge-counter"><?= $jumlah; ?></span>

                     <?php
                        }
                        ?>

                 </a>
                 <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                     <h6 class="dropdown-header" style="background-color: #cc0000;">
                         Meminta Persetujuan
                     </h6>
                     <?php
                        $query = $this->db->query("SELECT * FROM tb_permintaan WHERE status = 'Meminta persetujuan' ")->result_array();

                        $jumlah = $this->db->query("SELECT * FROM tb_permintaan WHERE status = 'Meminta persetujuan' ")->num_rows();

                        if ($jumlah > 0) { ?>
                         <a class="dropdown-item d-flex align-items-center" href="#">
                             <div class="font-weight-bold">
                                 <div class="text-truncate"><?= $jumlah; ?> Permintaan</div>
                             </div>
                         </a>

                     <?php
                        } else { ?>
                         <a class="dropdown-item d-flex align-items-center" href="#">
                             <div class="font-weight-bold">
                                 <div class="text-truncate">Tidak ada permintaan</div>
                             </div>
                         </a>
                     <?php
                        }

                        ?>

                 </div>
             </li>

         <?php
            }
            ?>


         <div class="topbar-divider d-none d-sm-block"></div>
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <img class="img-profile rounded-circle" src="<?= base_url('assets/ruang-admin'); ?>/img/admin.png" style="max-width: 60px">
                 <span class="ml-2 d-none d-lg-inline text-white small">
                     <?= $this->session->userdata('hak_pengguna'); ?>
                     <?php $id = $this->session->userdata('id'); ?>
                 </span>

             </a>
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 <a class="dropdown-item" href="<?= base_url('Detail_pengguna/detail/') . $id ?>">
                     <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                     Profile
                 </a>
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                     Keluar
                 </a>
             </div>
         </li>
     </ul>
 </nav>
 <!-- Topbar -->