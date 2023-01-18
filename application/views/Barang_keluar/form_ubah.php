   <!-- Container Fluid-->
   <div class="container-fluid" id="container-wrapper">
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="./">Barang Keluar</a></li>
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
                               <input type="hidden" name="id_keluar" value="<?= $id_keluar['id_keluar']; ?>">
                               <div class="form-group" id="simple-date1">
                                   <label for="simpleDataInput">Tanggal Keluar</label>
                                   <div class="input-group date">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                       </div>
                                       <input type="date" id="tanggal_keluar" value="<?= $id_keluar['tanggal_keluar']; ?>" class="form-control" name="tanggal_keluar">
                                   </div>
                                   <span class="text-danger" id="tanggal_masuk-error"><?= form_error('tanggal_masuk'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Nama Barang</label>
                                   <select class="select2-single form-control" id="kode_barang" name="kode_barang">
                                       <option value="">Pilih barang</option>
                                       <?php
                                        foreach ($barang as $key => $value) { ?>
                                           <option <?php if ($value['kode_barang'] == $id_keluar['kode_barang']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_keluar['kode_barang']; ?>"><?= $value['nama_barang']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                                   <span class="text-danger" id="kode_barang-error"><?= form_error('kode_barang'); ?></span>
                               </div>

                           </div>
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="">Jumlah</label>
                                   <input type="hidden" class="form-control" id="jumlah_sebelum" name="jumlah_sebelum" value="<?= $id_keluar['jumlah']; ?>" readonly>
                                   <input type="text" class="form-control" id="jumlah_keluar" name="jumlah_keluar" value="<?= $id_keluar['jumlah']; ?>">
                                   <span class="text-danger" id="jumlah-error"><?= form_error('jumlah_keluar'); ?></span>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Ubah</button>
                           <a href="<?= base_url('Barang_keluar'); ?>" class="btn btn-warning ml-1">Kembali</a>
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
   </script>