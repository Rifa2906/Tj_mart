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


                                         <a class="btn btn-warning btn-sm" href="<?= base_url('Stok_barang/form_ubah') ?>/<?= $value['id_barang']; ?>" data-toggle="tooltip" data-placement="top" title="Ubah">
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
                             <label for="">Kode Barang</label>
                             <input class="form-control" type="text" id="kode_barang" readonly>
                         </div>
                         <div class="form-group">
                             <label for="">Nama Barang</label>
                             <input type="text" class="form-control" id="nama_barang">
                             <small class="text-danger" id="nama_barang-error"></small>
                         </div>
                         <div class="form-group">
                             <label for="select2Single">Satuan</label><br>
                             <select class="select2-single form-control" id="satuan">
                                 <option value="">Pilih satuan</option>
                                 <?php
                                    foreach ($satuan as $key => $value) { ?>
                                     <option value="<?= $value['id_satuan']; ?>"><?= $value['satuan']; ?></option>

                                 <?php
                                    }
                                    ?>
                             </select>
                             <small class="text-danger" id="satuan-error"></small>
                         </div>

                         <div class="form-group">
                             <label for="select2Single">Jenis barang</label><br>
                             <select class="select2-single form-control" id="jenis">
                                 <option value="">Pilih jenis barang</option>
                                 <?php
                                    foreach ($jenis as $key => $value) { ?>
                                     <option value="<?= $value['id_jenis']; ?>"><?= $value['nama_jenis']; ?></option>

                                 <?php
                                    }
                                    ?>
                             </select>
                             <small class="text-danger" id="jenis-error"></small>
                         </div>
                         <div class="form-group">
                             <label for="">Jumlah stok</label>
                             <input type="text" class="form-control" id="stok">
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
                 confirmButtonText: 'Oke'
             }).then((result) => {
                 if (result.isConfirmed) {
                     location.reload();
                 }
             })
         }

         function simpan() {

             kode_barang = $("#kode_barang").val();
             nama_barang = $("#nama_barang").val();
             satuan = $("#satuan").val();
             jenis = $("#jenis").val();
             stok = $("#stok").val();
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('Stok_barang/tambah_data') ?>',
                 data: {
                     kode_barang: kode_barang,
                     nama_barang: nama_barang,
                     satuan,
                     satuan,
                     jenis: jenis,
                     stok: stok
                 },
                 dataType: 'json',
                 success: function(data) {
                     if (data.status == 1) {
                         $("#Modal_stok_barang").modal('hide');
                         swall('stok barang', 'ditambahkan');
                     } else if (data.status == 0) {
                         $("#nama_barang-error").html(data['nama_barang']);
                         $("#jenis-error").html(data['jenis']);
                         $("#satuan-error").html(data['satuan']);
                         $("#stok-error").html(data['stok']);
                     }
                 }
             })
         }

         //  function ambil_id(x) {
         //      $.ajax({
         //          type: 'POST',
         //          url: '<?= base_url('Stok_barang/ambil_IdBarang') ?>',
         //          data: {
         //              id_barang: x
         //          },
         //          dataType: 'json',
         //          success: function(data) {
         //              $("#id_barang").val(data.id_barang);
         //              $("#Edt_kode_barang").val(data.kode_barang);
         //              $("#Edt_nama_barang").val(data.nama_barang);

         //              var baris_satuan = '<option selected="selected" value="">Pilih satuan</option>';
         //              for (let i = 0; i < data.data_satuan.length; i++) {
         //                  const element = data.data_satuan[i];
         //                  baris_satuan += '<option value="' + element.id_satuan + '" >' + element.satuan + '</option>';
         //              }

         //              $('#Edt_satuan').html(baris_satuan);
         //              $('#Edt_satuan option:selected').val(data.satuan)


         //              var baris_jenis = '<option value="">Pilih jenis</option>';
         //              for (let i = 0; i < data.data_jenis.length; i++) {
         //                  const element = data.data_jenis[i];
         //                  baris_jenis += '<option value="' + element.id_jenis + '" >' + element.nama_jenis + '</option>';
         //              }

         //              $('#Edt_jenis').html(baris_jenis);


         //              $("#Edt_stok").val(data.stok);
         //          }
         //      })
         //  }

         //  function ubah() {
         //      id_barang = $("#id_barang").val();
         //      Edt_kode_barang = $("#Edt_kode_barang").val();
         //      Edt_nama_barang = $("#Edt_nama_barang").val();
         //      Edt_satuan = $("#Edt_satuan").val();
         //      Edt_jenis = $("#Edt_jenis").val();
         //      Edt_stok = $("#Edt_stok").val();

         //      $.ajax({
         //          type: 'POST',
         //          url: '<?= base_url('Stok_barang/ubah_data') ?>',
         //          data: {
         //              id_barang: id_barang,
         //              Edt_kode_barang,
         //              Edt_kode_barang,
         //              Edt_nama_barang: Edt_nama_barang,
         //              Edt_satuan: Edt_satuan,
         //              Edt_jenis: Edt_jenis,
         //              Edt_stok: Edt_stok
         //          },
         //          dataType: 'json',
         //          success: function(data) {
         //              if (data.status == 1) {
         //                  $("#Modal_stok_edit").modal('hide');
         //                  $("#Edt_kode_barang").val('');
         //                  $("#Edt_nama_barang").val('');
         //                  $("#Edt_satuan").val('');
         //                  $("#Edt_jenis").val('');
         //                  $("#Edt_stok").val('');
         //                  swall('stok barang', 'diubah');
         //              } else if (data.status == 0) {
         //                  $("#Edt_nama_barang-error").html(data['Edt_nama_barang']);
         //                  $("#Edt_jenis-error").html(data['Edt_jenis']);
         //                  $("#Edt_satuan-error").html(data['Edt_satuan']);
         //                  $("#Edt_stok-error").html(data['Edt_stok']);
         //              }
         //          }
         //      })
         //  }

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
                             id_barang: x
                         },
                         dataType: 'json',
                         success: function(data) {}
                     })

                     swall('Stok barang', 'dihapus')

                 }
             })
         }
     </script>