   <!-- Container Fluid-->
   <div class="container-fluid" id="container-wrapper">
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="./">Barang Masuk</a></li>
               <li class="breadcrumb-item"><?= $title; ?></li>
           </ol>
       </div>
       <div class="row">
           <!-- Select2 -->
           <div class="card mb-4 w-75">
               <div class="card-body">
                   <form method="POST">
                       <div class="row">
                           <div class="col-6">
                               <div class="form-group" id="simple-date1">
                                   <label for="simpleDataInput">Tanggal Masuk</label>
                                   <div class="input-group date">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                       </div>
                                       <input type="date" id="tanggal_masuk" class="form-control" name="tanggal_masuk">
                                   </div>
                                   <span class="text-danger" id="tanggal_masuk-error"><?= form_error('tanggal_masuk'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Nama Barang</label><br>
                                   <select class="select2-single form-control" id="nama_barang" name="nama_barang">
                                       <option value="">Pilih barang</option>
                                       <?php
                                        foreach ($brg as $key => $value) { ?>
                                           <option value="<?= $value['id_barang']; ?>"><?= $value['nama_barang']; ?></option>

                                       <?php
                                        }
                                        ?>
                                   </select>
                                   <span class="text-danger" id="nama_barang-error"><?= form_error('nama_barang'); ?></span>
                               </div>
                               <div class="form-group">
                                   <div class="row">
                                       <div class="col-4">
                                           <label for="">Jumlah</label>
                                           <input type="text" class="form-control" id="jumlah" name="jumlah">
                                           <span class="text-danger" id="jumlah-error"><?= form_error('jumlah'); ?></span>
                                       </div>
                                       <div class="col-4">
                                           <label for="">Jumlah stok</label>
                                           <input type="text" class="form-control" id="jumlah_stok" name="jumlah_stok" readonly>
                                       </div>
                                   </div>

                               </div>
                           </div>
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="">Pemasok</label><br>
                                   <select class="form-control select2-single-placeholder" name="pemasok" id="pemasok">
                                       <option value="">Select</option>
                                       <?php
                                        foreach ($pemasok as $key => $value) { ?>
                                           <option value="<?= $value['id_pemasok']; ?>"><?= $value['nama_pemasok']; ?></option>

                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>
                               <span class="text-danger" id="pemasok-error"><?= form_error('pemasok'); ?></span>
                               <div class="form-group" id="simple-date1">
                                   <label for="simpleDataInput">Tanggal Kadaluarsa</label>
                                   <div class="input-group date">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                       </div>
                                       <input type="date" class="form-control" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa">
                                   </div>
                                   <span class="text-danger" id="tanggal_kadaluarsa-error"><?= form_error('tanggal_kadaluarsa'); ?></span>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Simpan</button>
                           <a href="<?= base_url('Barang_masuk'); ?>" class="btn btn-warning ml-1">Kembali</a>
                       </div>
                   </form>

               </div>
           </div>
       </div>
   </div>


   <script>
       $(function() {
           // Select2 Single  with Placeholder
           $('.select2-single-placeholder').select2({
               placeholder: "Pilih pemasok",
               allowClear: true
           });


           $('.select2-single').select2();

       })

       $("#nama_barang").change(function() {
           id_barang = $("#nama_barang").val();
           $.ajax({
               method: "POST",
               url: "<?= base_url('Barang_masuk/tampil_brg') ?>",
               data: {
                   id_brg: id_barang
               },
               dataType: "json",
               success: function(data) {
                   $("#jumlah_stok").val(data.stok);
               }
           })
       })
   </script>