<?php
if ($this->session->userdata('nama') == null) {
    $login = base_url('Login');
    header("Location:$login");
}
?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="jml_pengguna"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Pemasok</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="jml_pemasok"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck-moving fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Stok</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="jml_stok"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->



    </div>
    <?php
    if ($this->session->userdata('hak_pengguna') == 'kepala gudang') { ?>
        <div class="row">
            <!-- Area Chart -->
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header  bg-primary text-white py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-black">Monitoring Barang Kadaluarsa</h6>
                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal Kadaluarsa</th>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Jenis Barang</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tanggal_kemarin = date('d-m-Y', strtotime('-5 day', strtotime(date('d-m-Y'))));

                                    $tanggal_p = date('d-m-Y', strtotime('-1 day', strtotime(date('d-m-Y'))));

                                    foreach ($mkd as $key => $value) { ?>

                                        <tr>
                                            <td><?= date("d-m-Y", strtotime($value['tanggal_kadaluarsa']))  ?></td>
                                            <td><?= $value['nama_barang']; ?></td>
                                            <td><?= $value['jumlah']; ?></td>
                                            <td><?= $value['id_satuan']; ?></td>
                                            <td><?= $value['id_jenis']; ?></td>
                                            <td>
                                                <?php
                                                $tanggal_kadaluarsa = date("d-m-Y", strtotime($value['tanggal_kadaluarsa']));
                                                if ($tanggal_kadaluarsa >= $tanggal_kemarin && $tanggal_kadaluarsa <= $tanggal_p) { ?>
                                                    <span class="badge badge-warning p-2">segera kadaluarsa</span><br>
                                                <?php
                                                } else if ($tanggal_kadaluarsa >= date('d-m-Y')) { ?>
                                                    <span class="badge badge-danger p-2">kadaluarsa</span><br>
                                                <?php
                                                } else { ?>
                                                    <span class="badge badge-success p-2">Aman</span><br>
                                                <?php
                                                }
                                                ?>


                                            </td>
                                            <td>
                                                <?php
                                                if ($tanggal_kadaluarsa >= date('d-m-Y')) { ?>
                                                    <button type="button" onclick="tambah_kadaluarsa(<?= $value['id_monitoring'] ?>)" class="btn btn-danger btn-sm" id="btn-kdl"><i class="fas fa-solid fa-arrow-right"></i></button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php

                                    }

                                    ?>
                                </tbody>
                            </table>
                            <div class="card-footer text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php
    }
    ?>




</div>
<!---Container Fluid-->

<script>
    function tambah_kadaluarsa(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Halaman_utama/tambah_kadaluarsa') ?>',
            data: {
                id_monitoring: id
            },
            dataType: 'json',
            success: function(data) {
                if (data['status'] == 1) {
                    alert('Data berhasil disimpan ke tabel Kadaluarsa');
                    location.reload()
                }

            }
        })
    }


    $(function() {
        jml_data()

        function jml_data() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Halaman_utama/jml_data') ?>',
                dataType: 'json',
                success: function(data) {
                    $('#jml_pengguna').text(data.pengguna);
                    $('#jml_pemasok').text(data.pemasok);
                    $('#jml_stok').text(data.stok);
                    $('#brg_masuk').val(data.brg_masuk);
                    $('#brg_keluar').val(data.brg_keluar);
                }
            })
        }

        // Pie Chart Example
        var ctx = document.getElementById("Pie");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Direct", "Referral", "Social"],
                datasets: [{
                    data: [55, 30],
                    backgroundColor: ['#4e73df', '#1cc88a'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });

    })
</script>