     <!-- Container Fluid-->
     <div class="container-fluid" id="container-wrapper">
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
         </div>

         <div class="row">
             <div class="card mb-4 w-25">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Barang Masuk</h6>
                 </div>
                 <div class="card-body">
                     <form method="post">
                         <div class="form-group">
                             <select class="form-control" name="tahun" required>
                                 <option value="">Pilih Tahun</option>
                                 <?php
                                    foreach ($tahun as $key => $value) { ?>
                                     <option value="<?= $value['tahun'] ?>"><?= $value['tahun'] ?></option>
                                 <?php
                                    }
                                    ?>


                             </select>
                         </div>
                     </form>
                     <a href="<?= base_url('Cetak_laporan/cetak'); ?>" target="_blank" class="btn btn-success">Cetak</a>
                 </div>
             </div>
         </div>



     </div>
     <!---Container Fluid-->

     <script>

     </script>