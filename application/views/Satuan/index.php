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
                      <button type="button" data-toggle="modal" data-target="#Modal_satuan" id="#exampleModal" onclick="submit('tambah')" class="btn btn-primary">Tambah</button>
                  </div>
                  <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush" id="dataTable">
                          <thead class="thead-light">
                              <tr>
                                  <th>Satuan</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                foreach ($satuan as $key => $value) { ?>
                                  <tr>
                                      <td><?= $value['satuan']; ?></td>
                                      <td>
                                          <a data-toggle="tooltip" data-placement="top" title="Ubah">
                                              <button data-toggle="modal" data-target="#Modal_satuan_edit" id="#exampleModal" onclick="ambil_id(<?= $value['id_satuan'] ?>)" class="btn btn-warning btn-sm">
                                                  <i class="fas fa-pencil-alt"></i>
                                              </button>
                                          </a>

                                          <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                              <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_satuan'] ?>)">
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
  <div class="modal fade" id="Modal_satuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <input type="text" placeholder="Masukan satuan" class="form-control" id="satuan">
                          <span class="text-danger" id="satuan-error"></span>
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
  <div class="modal fade" id="Modal_satuan_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <input type="hidden" id="id_satuan">
                          <input type="text" class="form-control" id="satuan_edit">
                          <span class="text-danger" id="satuan_edit-error"></span>
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
      function swall(params1, params2) {
          Swal.fire({
              title: 'Data ' + params1,
              text: 'Berhasil  ' + params2,
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
          }).then((result) => {
              location.reload();
          })

      }

      function simpan() {

          var satuan = $("#satuan").val();

          $.ajax({
              type: 'POST',
              url: '<?= base_url('Satuan/tambah_satuan') ?>',
              data: {
                  satuan: satuan
              },
              dataType: 'json',
              success: function(data) {

                  if (data['status'] == 0) {
                      if (data['satuan'] != "") {
                          $("#satuan-error").html(data['satuan']);
                      } else {
                          $("#satuan-error").html('');
                      }



                  } else if (data['status'] == 1) {
                      $("#Modal_satuan").modal('hide');
                      $("#satuan").val('');
                      swall('satuan', 'Ditambahkan')


                  }

              }
          })

      }

      function ambil_id(x) {

          $.ajax({
              type: 'POST',
              url: '<?= base_url('Satuan/ambil_IdSatuan') ?>',
              data: {
                  id_satuan: x
              },
              dataType: 'json',
              success: function(data) {
                  $("#id_satuan").val(data.id_satuan);
                  $("#satuan_edit").val(data.satuan);
              }
          })

      }

      function ubah() {

          var id_satuan = $("#id_satuan").val();
          var satuan = $("#satuan_edit").val();

          $.ajax({
              type: 'POST',
              url: '<?= base_url('Satuan/ubah_data') ?>',
              data: {
                  id_satuan: id_satuan,
                  satuan: satuan
              },
              dataType: 'json',
              success: function(data) {

                  if (data['status'] == 0) {
                      if (data['satuan'] != "") {
                          $("#satuan_edit-error").html(data['satuan']);
                      } else {
                          $("#satuan_edit-error").html('');
                      }



                  } else if (data['status'] == 1) {
                      $("#Modal_satuan_edit").modal('hide');
                      $("#satuan_edit").val('');
                      swall('satuan', 'Diubah')


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
                      url: '<?= base_url('Satuan/hapus_data') ?>',
                      data: {
                          id_satuan: x
                      },
                      dataType: 'json',
                      success: function(data) {}
                  })

                  swall('satuan', 'dihapus')

              }
          })
      }
  </script>