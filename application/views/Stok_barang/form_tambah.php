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
           <div class="card mb-4">
               <div class="card-body">
                   <form method="POST">
                       <div class="row">
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="">Kode Barang</label>
                                   <input class="form-control" value="<?= $kode_brg; ?>" type="text" id="kode_barang_masuk" name="kode_barang" readonly>
                               </div>
                               <div class="form-group">
                                   <label for="">Nama Barang</label>
                                   <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                                   <span class="text-danger" id="nama_barang-error"><?= form_error('nama_barang'); ?></span>
                               </div>
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
                           </div>
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="select2Single">Jenis barang</label><br>
                                   <select class="select2-single form-control" id="nama_jenis" name="nama_jenis">
                                       <option value="">pilih jenis barang</option>
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
                                   <label for="">Jumlah stok</label>
                                   <input type="text" class="form-control" id="jumlah_stok" name="jumlah_stok">
                                   <span class="text-danger" id="jumlah-error"><?= form_error('jumlah'); ?></span>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Simpan</button>
                           <a href="<?= base_url('Stok_barang'); ?>" class="btn btn-warning ml-1">Kembali</a>
                       </div>
                   </form>

               </div>
           </div>
       </div>
   </div>


   <script>
       $(function() {



           $('.select2-single').select2();

           // Bootstrap Date Picker
           //    $('#simple-date1 .input-group.date').datepicker({
           //        format: 'dd/mm/yyyy',
           //        todayBtn: 'linked',
           //        todayHighlight: true,
           //        autoclose: true,
           //    });

       })
   </script>