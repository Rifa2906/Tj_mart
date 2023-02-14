   <!-- Container Fluid-->
   <div class="container-fluid" id="container-wrapper">
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="./">Data Barang</a></li>
               <li class="breadcrumb-item"><?= $title; ?></li>

           </ol>
       </div>
       <div class="row">
           <!-- Select2 -->
           <div class="card mb-4 w-75">
               <div class="card-body">
                   <form method="POST">
                       <!-- <div class="row">
                           <div class="col-6">
                               <div class="form-group">
                                   <input type="hidden" name="kode_barang" value="<?= $id_barang['kode_barang']; ?>">
                                   <input type="hidden" name="id_barang" value="<?= $id_barang['id_barang']; ?>">
                                   <label for="">Nama Barang</label>
                                   <input type="text" class="form-control" value="<?= $id_barang['nama_barang']; ?>" name="nama_barang">
                                   <span class="text-danger" id="nama_barang-error"><?= form_error('nama_barang'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Harga</label>
                                   <input type="text" class="form-control" value="<?= $id_barang['harga']; ?>" name="harga" id="harga">
                                   <span class="text-danger" id="harga-error"><?= form_error('harga'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Satuan</label>
                                   <select class="select2-single form-control" id="satuan" name="satuan">
                                       <option value="">Pilih Satuan</option>
                                       <?php
                                        foreach ($satuan as $key => $value) { ?>
                                           <option <?php if ($value['id_satuan'] == $id_barang['id_satuan']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_barang['id_satuan']; ?>"><?= $value['satuan']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>
                           </div>
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="">Jenis Barang</label>
                                   <select name="jenis_barang" class="select2-single form-control">
                                       <option value="">Pilih Jenis</option>
                                       <?php
                                        foreach ($jenis as $key => $value) { ?>
                                           <option <?php if ($value['id_jenis'] == $id_barang['id_jenis']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_barang['id_jenis']; ?>"><?= $value['nama_jenis']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                                   <span class="text-danger"><?= form_error('jenis_barang'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Supplier</label>
                                   <select name="supplier" class="select2-single form-control">
                                       <option value="">Pilih Jenis</option>
                                       <?php
                                        foreach ($pemasok as $key => $value) { ?>
                                           <option <?php if ($value['id_pemasok'] == $id_barang['id_pemasok']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_barang['id_pemasok']; ?>"><?= $value['nama_pemasok']; ?></option>
                                       <?php
                                        }
                                        ?>
                                       <span class="text-danger" id="jumlah-error"><?= form_error('supplier'); ?></span>

                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Ubah</button>
                           <a href="<?= base_url('Barang'); ?>" class="btn btn-warning ml-1">Kembali</a>
                       </div> -->
                       <div class="row">
                           <div class="col-6">
                               <div class="form-group">
                                   <input type="hidden" name="kode_barang" value="<?= $id_barang['kode_barang']; ?>">
                                   <input type="hidden" name="id_barang" value="<?= $id_barang['id_barang']; ?>">
                                   <label for="">Nama Barang</label>
                                   <input type="text" class="form-control" value="<?= $id_barang['nama_barang']; ?>" name="nama_barang">
                                   <span class="text-danger" id="nama_barang-error"><?= form_error('nama_barang'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Harga</label>
                                   <input type="text" class="form-control" value="<?= $id_barang['harga']; ?>" name="harga" id="harga">
                                   <span class="text-danger" id="harga-error"><?= form_error('harga'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Satuan</label>
                                   <select class="select2-single form-control" id="satuan" name="satuan">
                                       <option value="">Pilih Satuan</option>
                                       <?php
                                        foreach ($satuan as $key => $value) { ?>
                                           <option <?php if ($value['id_satuan'] == $id_barang['id_satuan']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_barang['id_satuan']; ?>"><?= $value['satuan']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                               </div>

                           </div>
                           <div class="col-6">
                               <div class="form-group">
                                   <label for="">Jenis Barang</label>
                                   <select name="jenis_barang" class="select2-single form-control">
                                       <option value="">Pilih Jenis</option>
                                       <?php
                                        foreach ($jenis as $key => $value) { ?>
                                           <option <?php if ($value['id_jenis'] == $id_barang['id_jenis']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_barang['id_jenis']; ?>"><?= $value['nama_jenis']; ?></option>
                                       <?php
                                        }
                                        ?>
                                   </select>
                                   <span class="text-danger"><?= form_error('jenis_barang'); ?></span>
                               </div>
                               <div class="form-group">
                                   <label for="">Supplier</label>
                                   <select name="supplier" class="select2-single form-control">
                                       <option value="">Pilih Jenis</option>
                                       <?php
                                        foreach ($pemasok as $key => $value) { ?>
                                           <option <?php if ($value['id_pemasok'] == $id_barang['id_pemasok']) {
                                                        echo 'selected';
                                                    } ?> value="<?= $id_barang['id_pemasok']; ?>"><?= $value['nama_pemasok']; ?></option>
                                       <?php
                                        }
                                        ?>
                                       <span class="text-danger" id="jumlah-error"><?= form_error('supplier'); ?></span>
                                   </select>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Ubah</button>
                           <a href="<?= base_url('Barang_masuk'); ?>" class="btn btn-warning ml-1">Kembali</a>
                       </div>
                   </form>

               </div>
           </div>
       </div>
   </div>


   <script>
       $(function() {


           $('#harga').mask('0.000.000.000', {
               reverse: true
           });
           $('.select2-single').select2();



       })
   </script>