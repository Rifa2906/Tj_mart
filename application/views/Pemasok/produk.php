  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Supplier</a></li>
              <li class="breadcrumb-item"><a href="./">Tambah produk</a></li>
              <li class="breadcrumb-item"><?= $title; ?></li>
          </ol>
      </div>



      <div class="row">
          <!-- Datatables -->
          <div class="col-lg-12">
              <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <button type="button" data-toggle="modal" data-target="#Modal_produk" id="#exampleModal" onclick="submit('tambah')" class="btn btn-primary">Tambah</button>
                  </div>
                  <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush" id="dataTable">
                          <thead class="thead-light">
                              <tr>
                                  <th>No</th>
                                  <th>Pemasok</th>
                                  <th>Produk</th>
                                  <th>Harga</th>
                                  <th>Satuan</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                $no = 1;
                                foreach ($produk as $key => $value) { ?>
                                  <tr>
                                      <td><?= $no++; ?></td>
                                      <td><?= $value['nama_pemasok'] ?></td>
                                      <td><?= $value['produk'] ?></td>
                                      <td>Rp. <?= number_format($value['harga'], 0, ',', '.'); ?></td>
                                      <td><?= $value['satuan']; ?></td>
                                      <td>
                                          <a data-toggle="tooltip" data-placement="top" title="Ubah">
                                              <button data-toggle="modal" data-target="#Modal_produk_edit" id="#exampleModal" onclick="ambil_id(<?= $value['id_produk'] ?>)" class="btn btn-warning btn-sm">
                                                  <i class="fas fa-pencil-alt"></i>
                                              </button>
                                          </a>

                                          <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                              <a href="<?= basename('Produk/form_edit'); ?>" class="btn btn-danger btn-sm">
                                                  <i class="fas fa-trash"></i>
                                              </a>
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

  <!-- Modal tambah produk -->
  <div class="modal fade" id="Modal_produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah produk</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form>
                      <div class="form-group">
                          <label for="">Pemasok</label>
                          <select id="pemasok" class="form-control">
                              <option value="">Pilih pemasok</option>
                              <?php
                                foreach ($pemasok as $key => $value) { ?>
                                  <option value="<?= $value['id_pemasok']; ?>"><?= $value['nama_pemasok']; ?></option>
                              <?php
                                }
                                ?>
                          </select>
                          <span class="text-danger" id="pemasok-error"></span>
                      </div>

                      <div class="form-group">
                          <label for="">Produk</label>
                          <input type="text" class="form-control" id="produk">
                          <span class="text-danger" id="produk-error"></span>
                      </div>

                      <div class="form-group">
                          <label for="">Harga</label>
                          <input type="text" class="form-control" id="harga">
                          <span class="text-danger" id="harga-error"></span>
                      </div>

                      <div class="form-group">
                          <label for="">Satuan</label>
                          <select id="satuan" class="form-control">
                              <option value="">Pilih satuan</option>
                              <?php
                                foreach ($satuan as $key => $value) { ?>
                                  <option value="<?= $value['id_satuan']; ?>"><?= $value['satuan']; ?></option>
                              <?php
                                }
                                ?>
                          </select>
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



  <script>
      $(function() {
          $('#harga').mask('0.000.000.000', {
              reverse: true
          });
      })

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

          id_pemasok = $('#pemasok').val();
          produk = $('#produk').val();
          harga = $('#harga').val();
          satuan = $('#satuan').val();
          $.ajax({
              type: 'POST',
              url: '<?= base_url('Produk/tambah_produk') ?>',
              data: {
                  pemasok: id_pemasok,
                  produk: produk,
                  harga: harga,
                  satuan: satuan
              },
              dataType: 'json',
              success: function(data) {
                  if (data.status == 0) {
                      $('#pemasok-error').html(data.pemasok)
                      $('#produk-error').html(data.produk)
                      $('#harga-error').html(data.harga)
                      $('#satuan-error').html(data.satuan)
                  } else if (data.status == 1) {
                      $("#Modal_produk").modal('hide');
                      swall('produk', 'ditambahkan');
                  }
              }
          })
      }
  </script>