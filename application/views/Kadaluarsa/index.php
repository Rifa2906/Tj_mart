  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Barang</a></li>
              <li class="breadcrumb-item"><?= $title; ?></li>
          </ol>
      </div>



      <div class="row">
          <!-- Datatables -->
          <div class="col-lg-12">
              <div class="card mb-4">
                  <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush" id="dataTable">
                          <thead class="thead-light">
                              <tr>
                                  <th>No</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Nama Barang</th>
                                  <th>Jumlah</th>
                                  <th>Satuan</th>
                                  <th>Jenis</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                $no = 1;
                                foreach ($kd as $key => $value) { ?>
                                  <tr>
                                      <td><?= $no++; ?></td>
                                      <td><?= $value['tanggal_kadaluarsa']; ?></td>
                                      <td><?= $value['nama_barang']; ?></td>
                                      <td><?= $value['jumlah']; ?></td>
                                      <td><?= $value['satuan']; ?></td>
                                      <td><?= $value['nama_jenis']; ?></td>
                                  </tr>

                              <?php
                                }
                                ?>

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>





  </div>
  <!---Container Fluid-->