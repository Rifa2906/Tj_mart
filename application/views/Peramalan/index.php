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

     </div>

     <div class="row">
         <!-- Datatables -->
         <div class="col-lg-12">
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                 </div>
                 <div class="table-responsive p-3">
                     <table class="table align-items-center table-flush" id="dataTable">
                         <thead class="thead-light">
                             <tr>
                                 <th>No</th>
                                 <th>Kode Barang</th>
                                 <th>Nama Barang</th>
                                 <th>Jenis Barang</th>
                                 <th>Stok</th>
                                 <th>Minimal Stok</th>
                                 <th>Satuan</th>
                                 <th>Aksi</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($peramalan as $key => $value) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= $value['kode_barang']; ?></td>
                                     <td><?= $value['nama_barang']; ?></td>
                                     <td><?= $value['nama_jenis']; ?></td>
                                     <td><?= $value['stok']; ?></td>
                                     <td><?= $value['minimal_stok']; ?></td>
                                     <td><?= $value['satuan']; ?></td>
                                     <td>
                                         <?php
                                            if ($value['stok'] < $value['minimal_stok']) { ?>
                                             <button data-toggle="modal" data-target="#Modal_peramalan" id="#exampleModal" onclick="peramalan(<?= $value['id_barang'] ?>,<?= $value['minimal_stok'] ?>)" data-toggle="tooltip" data-placement="top" title="Hasil Peramalan" class="btn btn-success btn-sm"><i class="fas fa-solid fa-calculator"></i></button>
                                         <?php
                                            }
                                            ?>

                                     </td>
                                 </tr>

                             <?php
                                }
                                ?>
                         </tbody>
                     </table>
                     <p class="jumlah"></p>
                 </div>
             </div>
         </div>



     </div>
     <!---Container Fluid-->

     <!-- Modal tambah satuan -->
     <div class="modal fade" id="Modal_peramalan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header bg-primary text-white">
                     <h5 class="modal-title" id="exampleModalLabel">Peramalan</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">

                     <table>
                         <tr>
                             <td>Produk</td>
                             <td> : </td>
                             <td id="produk"></td>
                         </tr>
                         <tr>
                             <td>Hasil Peramalan</td>
                             <td> : </td>
                             <td id="hasil_peramalan"></td>
                         </tr>

                         <tr>
                             <td>Untuk Bulan</td>
                             <td> : </td>
                             <td id="bulan"></td>
                         </tr>

                         <tr>
                             <td>Ke supplier</td>
                             <td> : </td>
                             <td id="supplier"></td>
                         </tr>
                     </table>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                 </div>
             </div>
         </div>
     </div>

     <script>
         $(function() {
             $('[data-toggle="tooltip"]').tooltip()
         })




         function peramalan(id_barang, min_stok, stok) {
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('Peramalan/peramalan') ?>',
                 dataType: 'json',
                 data: {
                     id_barang: id_barang,
                     min_stok: min_stok
                 },
                 success: function(data) {
                     $("#hasil_peramalan").text(data.peramalan + " Unit")
                     $("#bulan").text(data.bulan_berikutnya)
                     $("#produk").text(data.produk)

                 }
             })
         }
     </script>