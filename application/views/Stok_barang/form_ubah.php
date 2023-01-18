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

                       <div class="form-group">
                           <label for="">Nama Barang</label>
                           <input type="hidden" name="id_barang" value="<?= $id_stok['id_barang']; ?>">
                           <input class="form-control" id="Edt_nama_barang" name="Edt_nama_barang" value="<?= $id_stok['barang']; ?>">
                           <span class="text-danger" id="nama_barang-error"><?= form_error('Edt_nama_barang'); ?></span>
                       </div>
                       <div class="form-group">
                           <label for="">Stok</label>
                           <input type="text" class="form-control" id="Edt_stok" name="Edt_stok" value="<?= $id_stok['stok']; ?>">
                           <input type="hidden" class="form-control" id="Edt_status" name="Edt_status" value="<?= $id_stok['status']; ?>">
                           <span class="text-danger" id="stok-error"><?= form_error('Edt_stok'); ?></span>
                       </div>
                       <button type="submit" class="btn btn-primary">Ubah</button>
                       <a href="<?= base_url('Stok_barang'); ?>" class="btn btn-warning ml-1">Kembali</a>
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