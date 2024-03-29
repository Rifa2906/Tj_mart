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
             <div class="card">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <button type="button" data-toggle="modal" data-target="#Modal_stok_barang" id="#exampleModal" onclick="submit('tambah')" class="btn btn-primary">Tambah</button>
                 </div>
                 <div class="table-responsive p-3">
                     <?php
                        if ($this->session->flashdata('message')) { ?>
                         <div class="alert alert-success alert-dismissible" role="alert">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                             Data barang berhasil <?= $this->session->flashdata('message') ?>
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
                                 <th>Minimal Stok</th>
                                 <th>Satuan</th>
                                 <th>Status</th>
                                 <th>Aksi</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $no = 1;
                                foreach ($stok as $key => $value) { ?>
                                 <tr>
                                     <td><?= $no++; ?></td>
                                     <td><?= $value['kode_barang']; ?></td>
                                     <td><?= $value['nama_barang']; ?></td>
                                     <td><?= $value['nama_jenis']; ?></td>
                                     <td id="stok"><?= $value['stok']; ?></td>
                                     <td id="minimal_stok"><?= $value['minimal_stok']; ?></td>
                                     <td><?= $value['satuan']; ?></td>
                                     <td>

                                         <?php
                                            if ($value['status'] == "Stok aman") { ?>
                                             <span class="badge badge-success p-2"><i class="fas fa-shield-alt"></i> <?= $value['status']; ?></span>
                                         <?php
                                            } else if ($value['status'] == "Harus melakukan pengadaan") { ?>
                                             <span class="badge badge-danger p-2"><i class="fas fa-shield-alt"></i> <?= $value['status']; ?></span>
                                         <?php
                                            }
                                            ?>
                                     </td>
                                     <td>
                                         <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                             <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_stok'] ?>)">
                                                 <i class="fas fa-trash"></i>
                                             </button>
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

     <!-- Modal tambah stok barang -->
     <div class="modal fade" id="Modal_stok_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Tambah Stok Barang</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form>
                         <div class="form-group">
                             <label for="">Nama Barang</label>
                             <select class="select2-single form-control" id="kode_barang">
                                 <option value="">Pilih barang</option>
                                 <?php
                                    foreach ($barang as $key => $value) { ?>
                                     <option value="<?= $value['kode_barang']; ?>"><?= $value['kode_barang']; ?> - <?= $value['nama_barang']; ?></option>

                                 <?php
                                    }
                                    ?>
                             </select>
                             <small class="text-danger" id="kode_barang-error"></small>
                         </div>

                         <div class="form-group">
                             <label for="">Jumlah stok</label>
                             <input type="text" class="form-control" id="stok_barang">
                             <small class="text-danger" id="stok-error"></small>
                         </div>
                     </form>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                     <button type="button" id="btn-tambah" class="btn btn-primary" onclick="simpan()">Simpan</button>
                 </div>
             </div>
         </div>
     </div>




     <script>
         $(function() {
             $('[data-toggle="tooltip"]').tooltip()
             kode_barang()
             $('.select2-single').select2();
         })



         function kode_barang() {
             $.ajax({
                 url: '<?= base_url('Stok_barang/kode_otomatis') ?>',
                 dataType: 'json',
                 success: function(data) {
                     $("#kode_barang").val(data);
                 }
             })
         }

         function swall(params1, params2) {
             Swal.fire({
                 title: 'Data ' + params1,
                 text: 'Berhasil  ' + params2,
                 icon: 'success',
                 showConfirmButton: false,
                 timer: 1500
             }).then((result) => {
                 location.reload();
             })

         }



         function simpan() {
             kode_barang = $("#kode_barang").val();
             stok = $("#stok_barang").val();
             console.log(stok)
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('Stok_barang/tambah_data') ?>',
                 data: {
                     kode_barang: kode_barang,
                     stok: stok
                 },
                 dataType: 'json',
                 success: function(data) {
                     if (data.status == 1) {
                         $("#Modal_stok_barang").modal('hide');
                         swall('stok barang', 'ditambahkan');
                     } else if (data.status == 0) {
                         $("#kode_barang-error").html(data['kode_barang']);
                         $("#stok-error").html(data['Stok']);
                     }
                 }
             })
         }

         function hapus(x) {
             Swal.fire({
                 title: 'Apakah anda yakin ingin menghapusnya?',
                 showCancelButton: true,
                 confirmButtonText: 'Hapus',
                 icon: 'warning'
             }).then((result) => {
                 /* Read more about isConfirmed, isDenied below */
                 if (result.isConfirmed) {

                     $.ajax({
                         type: 'POST',
                         url: '<?= base_url('Stok_barang/hapus_data') ?>',
                         data: {
                             id_stok: x
                         },
                         dataType: 'json',
                         success: function(data) {}
                     })

                     swall('Stok barang', 'dihapus')

                 }
             })
         }
     </script>