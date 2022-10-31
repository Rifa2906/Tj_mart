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
                                   <input type="hidden" name="Edt_id_barang" value="<?= $id_barang['id_barang']; ?>">
                                   <label for="">Kode Barang</label>
                                   <input class="form-control" value="<?= $id_barang['kode_barang']; ?>" type="text" id="Edt_kode_barang" name="Edt_kode_barang" readonly>
                               </div>
                               <div class="form-group">
                                   <label for="">Nama Barang</label>
                                   <input class="form-control" id="Edt_nama_barang" name="Edt_nama_barang" value="<?= $id_barang['nama_barang']; ?>">
                                   <span class="text-danger" id="nama_barang-error"><?= form_error('Edt_nama_barang'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="select2Single">Satuan</label><br>
                                   <select class="form-control select2-single" id="Edt_satuan" name="Edt_satuan">
                                       <option value="">Pilih satuan</option>
                                       <?php
                                        foreach ($satuan as $key => $value) { ?>
                                           <option <?php if ($value['id_satuan'] == $id_barang['id_satuan']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $value['id_satuan']; ?>"><?= $value['satuan']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>
                               <span class="text-danger" id="satuan-error"><?= form_error('Edt_satuan'); ?></span>
                           </div>
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="select2Single">Jenis barang</label><br>
                                   <select class="form-control select2-single" id="Edt_jenis" name="Edt_jenis">
                                       <option value="">pilih jenis barang</option>
                                       <?php
                                        foreach ($jenis as $key => $value) { ?>
                                           <option <?php if ($value['id_jenis'] == $id_barang['id_jenis']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $value['id_jenis']; ?>"><?= $value['nama_jenis']; ?></option>

                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>
                               <span class="text-danger" id="jenis-error"><?= form_error('Edt_jenis'); ?></span>
                               <div class="form-group">
                                   <label for="">Stok</label>
                                   <input type="text" class="form-control" id="Edt_stok" name="Edt_stok" value="<?= $id_barang['stok']; ?>">
                                   <span class="text-danger" id="stok-error"><?= form_error('Edt_stok'); ?></span>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Ubah</button>
                           <a href="<?= base_url('Stok_barang'); ?>" class="btn btn-warning ml-1">Kembali</a>
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