  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
      </div>

      <!-- Row -->
      <div class="row">
          <!-- Datatables -->
          <div class="col-lg-12">
              <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <button type="button" data-toggle="modal" data-target="#Modal_pemasok" id="#exampleModal" class="btn btn-primary">Tambah</button>
                      <a href="<?= base_url('Produk'); ?>" class="btn btn-primary">Tambah Produk</a>
                  </div>

                  <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush" id="dataTable">
                          <thead class="thead-light">
                              <tr>
                                  <th>Kode pemasok</th>
                                  <th>Nama pemasok</th>
                                  <th>No telpon</th>
                                  <th>Alamat</th>
                                  <th>Produk</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                foreach ($pemasok as $key => $value) { ?>
                                  <tr>
                                      <td><?= $value['kode_pemasok']; ?></td>
                                      <td><?= $value['nama_pemasok']; ?></td>
                                      <td><?= $value['no_telpon']; ?></td>
                                      <td><?= $value['alamat']; ?></td>
                                      <td>

                                          <button data-toggle="modal" data-target="#Modal_produk" id="#exampleModal" onclick="tampil_produk(<?= $value['id_pemasok'] ?>)" class="btn btn-success btn-sm"><i data-toggle="tooltip" data-placement="top" title="Produk" class="fas fa-box"></i></button>

                                      </td>
                                      <td>
                                          <button data-toggle="tooltip" data-placement="top" title="Ubah" data-toggle="modal" data-target="#Modal_pemasok_edit" id="#exampleModal" onclick="ambil_id(<?= $value['id_pemasok'] ?>)" class="btn btn-warning btn-sm">
                                              <i class="fas fa-pencil-alt"></i>
                                          </button>


                                          <button data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_pemasok'] ?>)">
                                              <i class="fas fa-trash"></i>
                                          </button>
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
      <!---Container Fluid-->

      <!-- Modal pilih supplier -->
      <div class="modal fade" id="Modal_produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                  <div class="modal-header bg-primary">
                      <h5 class="modal-title text-white" id="exampleModalLabel">Produk</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <input type="hidden" id="id_peramalan">
                      <table class="table align-items-center table-flush table-hover" id="dataTable">
                          <thead>
                              <tr>
                                  <th>Produk</th>
                                  <th>harga</th>
                              </tr>
                          </thead>
                          <tbody id="target">

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>



      <!-- Modal tambah pemasok -->
      <div class="modal fade" id="Modal_pemasok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <label for="">Kode pemasok</label>
                              <input class="form-control" value="<?= $kode_pemasok; ?>" type="text" id="kode_pemasok" readonly>
                          </div>
                          <div class="form-group">
                              <label for="">Nama pemasok</label>
                              <input type="text" class="form-control" id="nama_pemasok">
                              <span class="text-danger" id="nama_pemasok-error"></span>
                          </div>
                          <div class="form-group">
                              <label for="">No Telpon</label>
                              <input type="text" class="form-control" id="no_telpon">
                              <span class="text-danger" id="no_telpon-error"></span>
                          </div>
                          <div class="form-group">
                              <label for="">Alamat</label>
                              <textarea id="alamat" class="form-control" rows="3"></textarea>
                              <span class="text-danger" id="alamat-error"></span>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                      <button type="button" id="btn-tambah" class="btn btn-primary" onclick="simpan()">Simpan</button>
                  </div>
              </div>
          </div>
      </div>

      <!-- Modal edit pemasok -->
      <div class="modal fade" id="Modal_pemasok_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <input type="hidden" id="id_pemasok">
                              <label for="">Kode pemasok</label>
                              <input class="form-control" type="text" id="kode_pemasok_edit" readonly>
                          </div>
                          <div class="form-group">
                              <label for="">Nama pemasok</label>
                              <input type="text" class="form-control" id="nama_pemasok_edit">
                              <span class="text-danger" id="nama_pemasok_edit-error"></span>
                          </div>
                          <div class="form-group">
                              <label for="">No Telpon</label>
                              <input type="text" class="form-control" id="no_telpon_edit">
                              <span class="text-danger" id="no_telpon_edit-error"></span>
                          </div>
                          <div class="form-group">
                              <label for="">Alamat</label>
                              <textarea id="alamat_edit" class="form-control" rows="3"></textarea>
                              <span class="text-danger" id="alamat_edit-error"></span>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                      <button type="button" id="btn-ubah" class="btn btn-primary" onclick="ubah()">Ubah</button>
                  </div>
              </div>
          </div>
      </div>

      <script>
          $(function() {
              $('[data-toggle="tooltip"]').tooltip()
          })

          function simpan() {

              var nama = $("#nama_pemasok").val();
              var kode_pemasok = $("#kode_pemasok").val();
              var no_telpon = $("#no_telpon").val();
              var alamat = $("#alamat").val();

              $.ajax({
                  type: 'POST',
                  url: '<?= base_url('Pemasok/tambah_pemasok') ?>',
                  data: {
                      kode_pemasok: kode_pemasok,
                      nama: nama,
                      no_telpon: no_telpon,
                      alamat: alamat,
                  },
                  dataType: 'json',
                  success: function(data) {

                      if (data['status'] == 0) {
                          if (data['nama_pemasok'] != "") {
                              $("#nama_pemasok-error").html(data['nama_pemasok']);
                          } else {
                              $("#nama_pemasok-error").html('');
                          }

                          if (data['alamat'] != "") {
                              $("#alamat-error").html(data['alamat']);
                          } else {
                              $("#alamat-error").html('');
                          }

                          if (data['no_telpon'] != "") {
                              $("#no_telpon-error").html(data['no_telpon']);
                          } else {
                              $("#no_telpon-error").html('');
                          }


                      } else if (data['status'] == 1) {
                          $("#Modal_pemasok").modal('hide');
                          $("#nama_pemasok").val('');
                          $("#no_telpon").val('');
                          $("#alamat").val('');

                          swall('pemasok', 'Ditambahkan')


                      }

                  }
              })


          }

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

          function ambil_id(x) {
              $.ajax({
                  type: 'POST',
                  url: '<?= base_url('Pemasok/ambil_IdPemasok') ?>',
                  data: {
                      id_pemasok: x
                  },
                  dataType: 'json',
                  success: function(data) {
                      $("#id_pemasok").val(data.id_pemasok);
                      $("#kode_pemasok_edit").val(data.kode_pemasok);
                      $("#nama_pemasok_edit").val(data.nama_pemasok);
                      $("#no_telpon_edit").val(data.no_telpon);
                      $("#alamat_edit").val(data.alamat);
                  }
              })
          }

          function ubah() {

              var id_pemasok = $("#id_pemasok").val();
              var nama_pemasok = $("#nama_pemasok_edit").val();
              var kode_pemasok = $("#kode_pemasok_edit").val();
              var no_telpon = $("#no_telpon_edit").val();
              var alamat = $("#alamat_edit").val();

              $.ajax({
                  type: 'POST',
                  url: '<?= base_url('Pemasok/ubah') ?>',
                  data: {
                      id_pemasok: id_pemasok,
                      kode_pemasok: kode_pemasok,
                      nama_pemasok: nama_pemasok,
                      no_telpon: no_telpon,
                      alamat: alamat,
                  },
                  dataType: 'json',
                  success: function(data) {

                      if (data['status'] == 0) {
                          if (data['nama_pemasok'] != "") {
                              $("#nama_pemasok_edit-error").html(data['nama_pemasok']);
                          } else {
                              $("#nama_pemasok_edit-error").html('');
                          }

                          if (data['alamat'] != "") {
                              $("#alamat_edit-error").html(data['alamat']);
                          } else {
                              $("#alamat_edit-error").html('');
                          }

                          if (data['no_telpon'] != "") {
                              $("#no_telpon_edit-error").html(data['no_telpon']);
                          } else {
                              $("#no_telpon_edit-error").html('');
                          }


                      } else if (data['status'] == 1) {
                          $("#Modal_pemasok_edit").modal('hide');
                          $("#nama_pemasok_edit").val('');
                          $("#no_telpon_edit").val('');
                          $("#alamat_edit").val('');

                          swall('pemasok', 'Diubah')


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
                          url: '<?= base_url('Pemasok/hapus_data') ?>',
                          data: {
                              id_pemasok: x
                          },
                          dataType: 'json',
                          success: function(data) {}
                      })

                      swall('pemasok', 'dihapus')

                  }
              })
          }

          function tampil_produk(id_pemasok) {
              $.ajax({
                  method: "POST",
                  url: "<?= base_url('Pemasok/tampil_produk') ?>",
                  data: {
                      id_pemasok: id_pemasok,
                  },
                  dataType: "json",
                  success: function(data) {

                      var html = '';
                      var i;
                      var produk = data;
                      for (i = 0; i < produk.length; i++) {
                          html += '<tr>' +
                              '<td>' + produk[i].produk + '</td>' +
                              '<td> Rp. ' + produk[i].harga + '</td>' +
                              '</tr>';
                      }
                      $('#target').html(html);



                  }
              })
          }
      </script>