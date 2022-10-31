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
                                 <th>Nama Barang</th>
                                 <th>Jumlah Pengadaan</th>
                                 <th>Satuan</th>
                                 <th>Status</th>
                                 <?php
                                    if ($this->session->userdata('hak_pengguna') == 'staf administrasi') { ?>
                                     <th>Aksi</th>
                                 <?php
                                    }
                                    ?>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($permintaan as $key => $value) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= $value['nama_barang']; ?></td>
                                     <td><?= $value['jumlah_pengadaan']; ?></td>
                                     <td><?= $value['satuan']; ?></td>
                                     <td class="font-weight-bold"><?= $value['status']; ?></td>
                                     <?php
                                        if ($this->session->userdata('hak_pengguna') == 'staf administrasi') { ?>
                                         <td>
                                             <?php
                                                if ($value['status'] == "Meminta persetujuan") { ?>
                                                 <button onclick="disetujui(<?= $value['id_permintaan'] ?>)" class="btn btn-success btn-sm">
                                                     Disetujui
                                                 </button>
                                                 <button onclick="ditolak(<?= $value['id_permintaan'] ?>)" class="btn btn-danger btn-sm">
                                                     Ditolak
                                                 </button>
                                             <?php
                                                }
                                                ?>


                                         </td>

                                     <?php
                                        }
                                        ?>

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

         function swall(produk, peramalan, satuan, bulan) {
             Swal.fire({
                 title: 'Produk : ' + produk + '<br>Hasil Peramalan : ' + peramalan + ' ' + satuan + '<br>Untuk Bulan : ' + bulan + '<br> Ke Supplier : ',
                 confirmButtonText: 'Oke'
             }).then((result) => {
                 if (result.isConfirmed) {
                     location.reload();
                 }
             })
         }

         function gagal_peramalan(produk) {
             Swal.fire({
                 title: 'Data ' + produk + ' belum bisa diramalkan',
                 confirmButtonText: 'Oke'
             }).then((result) => {
                 if (result.isConfirmed) {
                     location.reload();
                 }
             })
         }

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

                     if (data.status == 1) {
                         produk = data.produk;
                         peramalan = data.peramalan
                         bulan = data.bulan_berikutnya
                         satuan = data.satuan
                         jenis = data.jenis

                         swall(produk, peramalan, satuan, bulan)
                     } else if (data.status == 0) {
                         produk = data.produk;
                         gagal_peramalan(produk)
                     }


                 }
             })
         }

         function disetujui(x) {
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('Permintaan/Disetujui') ?>',
                 dataType: 'json',
                 data: {
                     id_permintaan: x,
                 },
                 success: function(data) {
                     if (data.status == 1) {

                         Swal.fire({
                             title: 'Data Permintaan',
                             text: 'Telah disetujui',
                             icon: 'success',
                             confirmButtonText: 'Oke'
                         }).then((result) => {
                             if (result.isConfirmed) {
                                 location.reload();
                             }
                         })
                     }
                 }
             })
         }

         function ditolak(x) {
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('Permintaan/Ditolak') ?>',
                 dataType: 'json',
                 data: {
                     id_permintaan: x,
                 },
                 success: function(data) {
                     if (data.status == 1) {

                         Swal.fire({
                             title: 'Data Permintaan',
                             text: 'Tidak disetujui',
                             icon: 'success',
                             confirmButtonText: 'Oke'
                         }).then((result) => {
                             if (result.isConfirmed) {
                                 location.reload();
                             }
                         })
                     }
                 }
             })
         }
     </script>