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
         <!-- Datatables -->
         <div class="col-lg-12">
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                 </div>
                 <div class="table-responsive p-3">
                     <table class="table align-items-center table-flush" id="dataTable">
                         <thead class="thead-light">
                             <tr>
                                 <th>Kode Barang</th>
                                 <th>Nama Barang</th>
                                 <th>Satuan</th>
                                 <th>Tanggal Kadaluarsa</th>
                                 <th>Stok</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>Tiger Nixon</td>
                                 <td>System Architect</td>
                                 <td>ss</td>
                                 <td>Edinburgh</td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>



     </div>
     <!---Container Fluid-->