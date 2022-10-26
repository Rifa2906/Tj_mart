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
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <button type="button" data-toggle="modal" data-target="#Modal_jenis_barang" id="#exampleModal" onclick="submit('tambah')" class="btn btn-primary">Tambah</button>
                  </div>
                  <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush" id="dataTable">
                          <thead class="thead-light">
                              <tr>
                                  <th>No</th>
                                  <th>Nama Jenis</th>
                                  <th>Minimal Stok</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                $no = 1;
                                foreach ($jenis as $key => $value) { ?>
                                  <tr>
                                      <td><?= $no++; ?></td>
                                      <td><?= $value['nama_jenis']; ?></td>
                                      <td><?= $value['minimal_stok']; ?></td>
                                      <td>
                                          <a data-toggle="tooltip" data-placement="top" title="Ubah">
                                              <button data-toggle="modal" data-target="#Modal_jenis_barang_edit" id="#exampleModal" onclick="ambil_id(<?= $value['id_jenis'] ?>)" class="btn btn-warning btn-sm">
                                                  <i class="fas fa-pencil-alt"></i>
                                              </button>
                                          </a>

                                          <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                              <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_jenis'] ?>)">
                                                  <i class="fas fa-trash"></i>
                                              </button>
                                          </a>
                                      </td>
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

  <!-- Modal tambah satuan -->
  <div class="modal fade" id="Modal_jenis_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="form-group">
                          <input type="text" placeholder="Masukan jenis barang" class="form-control" id="nama_jenis">
                          <span class="text-danger" id="nama_jenis-error"></span>
                      </div>
              </div>
              </form>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                  <button type="button" id="btn-tambah" class="btn btn-primary" onclick="simpan()">Simpan</button>
              </div>
          </div>
      </div>
  </div>

  <!-- Modal edit satuan -->
  <div class="modal fade" id="Modal_jenis_barang_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="form-group">
                          <input type="hidden" id="id_jenis">
                          <input type="text" class="form-control" id="edit_nama_jenis">
                          <span class="text-danger" id="edit_nama_jenis-error"></span>
                      </div>
              </div>
              </form>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                  <button type="button" id="btn-tambah" class="btn btn-primary" onclick="ubah()">Ubah</button>
              </div>
          </div>
      </div>
  </div>

  <script>
      $(function() {
          $('[data-toggle="tooltip"]').tooltip()
      })

      function swall(params1, params2) {
          Swal.fire({
              title: 'Data ' + params1,
              text: 'Berhasil  ' + params2,
              icon: 'success',
              confirmButtonText: 'Oke'
          }).then((result) => {
              if (result.isConfirmed) {
                  location.reload();
              }
          })
      }

      function simpan() {

          var nama_jenis = $("#nama_jenis").val();

          $.ajax({
              type: 'POST',
              url: '<?= base_url('Jenis_barang/tambah_jenis_barang') ?>',
              data: {
                  nama_jenis: nama_jenis
              },
              dataType: 'json',
              success: function(data) {

                  if (data['status'] == 0) {
                      if (data['nama_jenis'] != "") {
                          $("#nama_jenis-error").html(data['nama_jenis']);
                      } else {
                          $("#nama_jenis-error").html('');
                      }



                  } else if (data['status'] == 1) {
                      $("#Modal_jenis_barang").modal('hide');
                      $("#nama_jenis").val('');
                      swall('jenis barang', 'Ditambahkan')


                  }

              }
          })

      }

      function ambil_id(x) {

          $.ajax({
              type: 'POST',
              url: '<?= base_url('Jenis_barang/ambil_Idjenis') ?>',
              data: {
                  id_jenis: x
              },
              dataType: 'json',
              success: function(data) {
                  $("#id_jenis").val(data.id_jenis);
                  $("#edit_nama_jenis").val(data.nama_jenis);
              }
          })

      }

      function ubah() {

          var id_jenis = $("#id_jenis").val();
          var nama_jenis = $("#edit_nama_jenis").val();

          $.ajax({
              type: 'POST',
              url: '<?= base_url('Jenis_barang/ubah_data') ?>',
              data: {
                  id_jenis: id_jenis,
                  nama_jenis: nama_jenis
              },
              dataType: 'json',
              success: function(data) {

                  if (data['status'] == 0) {
                      if (data['nama_jenis'] != "") {
                          $("#edit_nama_jenis-error").html(data['nama_jenis']);
                      } else {
                          $("#edit_nama_jenis-error").html('');
                      }



                  } else if (data['status'] == 1) {
                      $("#Modal_jenis_barang_edit").modal('hide');
                      $("#edit_nama_jenis").val('');
                      swall('jenis barang', 'Diubah')


                  }

              }
          })

      }

      function hapus(x) {
          Swal.fire({
              title: 'Apakah anda yakin ingin menghapusnya?',
              showCancelButton: true,
              confirmButtonText: 'Hapus',
              icon: 'warning'
          }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {

                  $.ajax({
                      type: 'POST',
                      url: '<?= base_url('Jenis_barang/hapus_data') ?>',
                      data: {
                          id_jenis: x
                      },
                      dataType: 'json',
                      success: function(data) {}
                  })

                  swall('jenis barang', 'dihapus')

              }
          })
      }
  </script>