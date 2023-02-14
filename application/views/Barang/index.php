  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>

      </div>



      <div class="row">
          <!-- Datatables -->
          <div class="col-lg-12">
              <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <button type="button" data-toggle="modal" data-target="#Modal_produk" id="#exampleModal" onclick="submit('tambah')" class="btn btn-primary">Tambah</button>
                  </div>
                  <div class="table-responsive p-3">
                      <?php
                        if ($this->session->flashdata('message')) { ?>
                          <div class="alert alert-success alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                              Data barang berhasil <?= $this->session->flashdata('message') ?>
                          </div>
                      <?php
                        }
                        ?>
                      <table class="table align-items-center table-flush" id="dataTable">
                          <thead class="thead-light">
                              <tr>
                                  <th>No</th>
                                  <th>Kode Barang</th>
                                  <th>Nama Barang</th>
                                  <th>Harga</th>
                                  <th>Satuan</th>
                                  <th>Jenis</th>
                                  <th>Supplier</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                $no = 1;
                                foreach ($barang as $key => $value) { ?>
                                  <tr>
                                      <td><?= $no++; ?></td>
                                      <td><?= $value['kode_barang']; ?></td>
                                      <td><?= $value['nama_barang'] ?></td>
                                      <td>Rp. <?= number_format($value['harga'], 0, ',', '.'); ?></td>
                                      <td><?= $value['satuan']; ?></td>
                                      <td><?= $value['nama_jenis']; ?></td>
                                      <td><?= $value['nama_pemasok']; ?></td>
                                      <td>
                                          <a data-toggle="tooltip" data-placement="top" title="Ubah">
                                              <a href="<?= base_url('Barang/form_ubah/') . $value['id_barang']; ?>" class="btn btn-warning btn-sm">
                                                  <i class="fas fa-pencil-alt"></i>
                                              </a>
                                          </a>

                                          <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                              <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_barang'] ?>)">
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

  <!-- Modal tambah produk -->
  <div class="modal fade" id="Modal_produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
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
                          <label for="">Kode Barang</label>
                          <input type="text" class="form-control" readonly value="<?= $kode_barang; ?>" id="kode_barang">
                          <span class="text-danger" id="kode_barang-error"></span>
                      </div>

                      <div class="form-group">
                          <label for="">Barang</label>
                          <input type="text" class="form-control" id="barang">
                          <span class="text-danger" id="barang-error"></span>
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
                      <div class="form-group">
                          <label for="">Jenis</label>
                          <select id="jenis" class="form-control">
                              <option value="">Pilih jenis</option>
                              <?php
                                foreach ($jenis as $key => $value) { ?>
                                  <option value="<?= $value['id_jenis']; ?>"><?= $value['nama_jenis']; ?></option>
                              <?php
                                }
                                ?>
                          </select>
                          <span class="text-danger" id="jenis-error"></span>
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
          kode_barang = $('#kode_barang').val();
          barang = $('#barang').val();
          harga = $('#harga').val();
          satuan = $('#satuan').val();
          jenis = $('#jenis').val();
          $.ajax({
              type: 'POST',
              url: '<?= base_url('Barang/tambah_barang') ?>',
              data: {
                  pemasok: id_pemasok,
                  barang: barang,
                  kode_barang: kode_barang,
                  harga: harga,
                  satuan: satuan,
                  jenis: jenis
              },
              dataType: 'json',
              success: function(data) {
                  if (data.status == 0) {
                      $('#pemasok-error').html(data.pemasok)
                      $('#barang-error').html(data.barang)
                      $('#harga-error').html(data.harga)
                      $('#satuan-error').html(data.satuan)
                      $('#jenis-error').html(data.jenis)
                  } else if (data.status == 1) {
                      $("#Modal_produk").modal('hide');
                      swall('Barang', 'ditambahkan');
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
                      url: '<?= base_url('Barang/hapus_data') ?>',
                      data: {
                          id_barang: x
                      },
                      dataType: 'json',
                      success: function(data) {}
                  })

                  swall('Barang', 'dihapus')

              }
          })
      }
  </script>