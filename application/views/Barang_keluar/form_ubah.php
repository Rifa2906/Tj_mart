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
                               <div class="form-group">
                                   <input type="hidden" name="id_keluar" value="<?= $id_keluar['id_keluar']; ?>">
                                   <label for="">Kode Barang Keluar</label>
                                   <input class="form-control" value="<?= $id_keluar['kode_barang_keluar']; ?>" type="text" id="kode_barang_keluar" name="kode_barang_keluar" readonly>
                               </div>
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
                                   <select class="select2-single form-control" id="nama_barang" name="nama_barang">
                                       <option value="">Pilih barang</option>
                                       <?php
                                        foreach ($brg as $key => $value) { ?>
                                           <option <?php if ($value['id_barang'] == $id_keluar['id_barang']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_keluar['id_barang']; ?>"><?= $value['nama_barang']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                                   <span class="text-danger" id="nama_barang-error"><?= form_error('nama_barang'); ?></span>
                               </div>

                           </div>
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="select2Single">Satuan</label><br>
                                   <select class="select2-single form-control" id="satuan" name="satuan">
                                       <option value="">Pilih satuan</option>
                                       <?php
                                        foreach ($satuan as $key => $value) { ?>
                                           <option <?php if ($value['id_satuan'] == $id_keluar['id_satuan']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_keluar['id_satuan']; ?>"><?= $value['satuan']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>
                               <span class="text-danger" id="satuan-error"><?= form_error('satuan'); ?></span>
                               <div class="form-group">
                                   <label for="select2Single">Jenis barang</label><br>
                                   <select class="form-control" id="nama_jenis" name="nama_jenis">
                                       <option value="">Pilih jenis barang</option>
                                       <?php
                                        foreach ($jenis as $key => $value) { ?>
                                           <option <?php if ($value['id_jenis'] == $id_keluar['id_jenis']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_keluar['id_jenis']; ?>"><?= $value['nama_jenis']; ?></option>

                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>
                               <span class="text-danger" id="nama_jenis-error"><?= form_error('nama_jenis'); ?></span>
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