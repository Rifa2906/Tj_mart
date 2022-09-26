 <?php
    if ($this->session->userdata('nama') == null) {
        $login = base_url('Login');
        header("Location:$login");
    }
    ?>
 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
         <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="./">Barang</a></li>
             <li class="breadcrumb-item"><?= $title; ?></li>
         </ol>
     </div>

     <div class="row">
         <!-- Datatables -->
         <div class="col-lg-12">
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <a href="<?= base_url('Stok_barang/form_tambah'); ?>" class="btn btn-primary">
                         Tambah
                     </a>
                 </div>
                 <div class="table-responsive p-3">
                     <?php
                        if ($this->session->flashdata('message')) { ?>
                         <div class="alert alert-success alert-dismissible" role="alert">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                             Data stok barang berhasil <?= $this->session->flashdata('message') ?>
                         </div>
                     <?php
                        }
                        ?>
                     <table class="table align-items-center table-flush" id="dataTable">
                         <thead class="thead-light">
                             <tr>
                                 <th>No</th>
                                 <th>Kode Barang</th>
                                 <th>Nama Barang</th>
                                 <th>Jenis Barang</th>
                                 <th>Stok</th>
                                 <th>Satuan</th>
                                 <th>Aksi</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($brg as $key => $value) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= $value['kode_barang']; ?></td>
                                     <td><?= $value['nama_barang']; ?></td>
                                     <td><?= $value['nama_jenis']; ?></td>
                                     <td><?= $value['stok']; ?></td>
                                     <td><?= $value['satuan']; ?></td>
                                     <td>
                                         <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                             <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_barang'] ?>)">
                                                 <i class="fas fa-trash"></i>
                                             </button>
                                         </a>



                                         <a href="<?= base_url('Stok_barang/form_ubah/') . $value['id_barang']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah">
                                             <i class="fas fa-pencil-alt"></i>
                                         </a>
                                     </td>
                                 </tr>
                             <?php
                                }
                                ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>



     </div>
     <!---Container Fluid-->

     <script>
         $(function() {
             $('[data-toggle="tooltip"]').tooltip()
         })

         function swall(params1, params2) {
             Swal.fire({
                 title: 'Data ' + params1,
                 text: 'Berhasil  ' + params2,
                 icon: 'success',
                 confirmButtonText: 'Oke'
             }).then((result) => {
                 if (result.isConfirmed) {
                     location.reload();
                 }
             })
         }
     </script>