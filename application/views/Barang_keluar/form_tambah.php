   <!-- Container Fluid-->
   <div class="container-fluid" id="container-wrapper">
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="./">Home</a></li>
               <li class="breadcrumb-item">Pages</li>
               <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
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
                                   <label for="">Kode Barang Keluar</label>
                                   <input class="form-control" value="<?= $kode_bk; ?>" type="text" id="kode_barang_keluar" name="kode_barang_keluar" readonly>
                               </div>
                               <div class="form-group" id="simple-date1">
                                   <label for="simpleDataInput">Tanggal Keluar</label>
                                   <div class="input-group date">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                       </div>
                                       <input type="date" id="tanggal_keluar" class="form-control" name="tanggal_keluar">
                                   </div>
                                   <span class="text-danger" id="tanggal_masuk-error"><?= form_error('tanggal_keluar'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Nama Barang</label><br>
                                   <select class="select2-single form-control" id="nama_barang" name="nama_barang">
                                       <option value="">Pilih barang</option>
                                       <?php
                                        foreach ($brg as $key => $value) { ?>
                                           <?php
                                            if ($value['stok'] > 0) { ?>
                                               <option value="<?= $value['id_barang']; ?>">
                                                   <?= $value['nama_barang']; ?></option>
                                           <?php
                                            }
                                            ?>


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
                                           <option value="<?= $value['id_satuan']; ?>"><?= $value['satuan']; ?></option>

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
                                           <option value="<?= $value['id_jenis']; ?>"><?= $value['nama_jenis']; ?></option>

                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>
                               <span class="text-danger" id="nama_jenis-error"><?= form_error('nama_jenis'); ?></span>
                               <div class="form-group">
                                   <label for="">Jumlah keluar</label>
                                   <input type="hidden" name="jumlah_stok_G" id="jumlah_stok_G">
                                   <input type="text" class="form-control" id="jumlah_keluar" name="jumlah_keluar">
                                   <span class="text-danger" id="jumlah_keluar-error"><?= form_error('jumlah_keluar'); ?></span>
                                   <p class="text-danger mt-3" id="jumlah_stok"></p>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Simpan</button>
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

       $("#nama_barang").change(function() {
           id_barang = $("#nama_barang").val();
           $.ajax({
               method: "POST",
               url: "<?= base_url('Barang_keluar/tampil_brg') ?>",
               data: {
                   id_brg: id_barang
               },
               dataType: "json",
               success: function(data) {
                   $("#jumlah_stok").text("Jangan lebih dari : " +
                       data.stok);
                   $("#jumlah_stok_G").val(data.stok);
               }
           })
       })
   </script>