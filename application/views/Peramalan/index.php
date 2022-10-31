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
                     <form action="<?= base_url('Peramalan/tambah_data'); ?>" method="post">
                         <div class="row">
                             <div class="form-group">
                                 <select class="select2-single form-control" id="nama_barang" name="id_barang">
                                     <option value="">Pilih barang</option>
                                     <?php
                                        foreach ($barang as $key => $value) { ?>
                                         <option value="<?= $value['id_barang']; ?>"><?= $value['nama_barang']; ?></option>

                                     <?php
                                        }
                                        ?>
                                 </select>
                                 <span class="text-danger"><?= form_error('id_barang'); ?></span>
                             </div>
                             <div class="form-group ml-3">
                                 <button type="submit" class="btn btn-primary">Tambah</button>
                             </div>

                         </div>

                     </form>

                 </div>
                 <div class="table-responsive p-3">
                     <table class="table align-items-center table-flush" id="dataTable">
                         <thead class="thead-light">
                             <tr>
                                 <th>No</th>
                                 <th>Nama Barang</th>
                                 <th>Stok</th>
                                 <th>Minimal Stok</th>
                                 <th>Aksi</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($peramalan as $key => $value) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= $value['nama_barang']; ?></td>
                                     <td><?= $value['stok']; ?></td>
                                     <td><?= $value['minimal_stok']; ?></td>
                                     <td>
                                         <?php
                                            if ($value['stok'] < $value['minimal_stok']) { ?>
                                             <button data-toggle="tooltip" data-placement="top" title="Hasil Peramalan" onclick="peramalan(<?= $value['id_barang'] ?>,<?= $value['minimal_stok'] ?>)" class="btn btn-success btn-sm"><i class="fas fa-solid fa-calculator"></i></button>

                                             <button onclick="kirim(<?= $value['id_peramalan'] ?>,<?= $value['id_barang'] ?>)" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Kirim ke tabel permintaan"><i class="fas fa-sharp fa-solid fa-paper-plane"></i></button>

                                             <button onclick="hapus(<?= $value['id_peramalan'] ?>)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus data"><i class="fas fa-trash"></i></button>
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

                 </div>
             </div>
         </div>



     </div>
     <!---Container Fluid-->




     <script>
         $(function() {
             $('[data-toggle="tooltip"]').tooltip()
             $('.select2-single').select2();
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

         function kirim(id_peramalan, id_barang) {
             $.ajax({
                 method: "POST",
                 url: "<?= base_url('Peramalan/kirim') ?>",
                 data: {
                     id_peramalan: id_peramalan,
                     id_barang: id_barang
                 },
                 dataType: "json",
                 success: function(data) {

                     if (data.status == 1) {

                         Swal.fire({
                             title: 'Data',
                             text: 'Berhasil disimpan ke tabel permintaan',
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

         function hapus(x) {
             $.ajax({
                 method: "POST",
                 url: "<?= base_url('Peramalan/hapus_data') ?>",
                 data: {
                     id_peramalan: x
                 },
                 dataType: "json",
                 success: function(data) {
                     if (data.status == 1) {
                         Swal.fire({
                             title: 'Data',
                             text: 'Berhasil dihapus',
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