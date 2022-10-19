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

    <div class="row">
        <!-- Area Chart -->
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header  bg-primary text-white py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-black">Barang</h6>
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tanggal_sekarang = date('Y-m-d', strtotime("-3 day", strtotime(date("Y-m-d"))));

                                foreach ($brg as $key => $value) { ?>

                                    <tr>
                                        <td><?= date("d-m-Y", strtotime($value['tanggal_kadaluarsa']))  ?></td>
                                        <td><?= $value['nama_barang']; ?></td>
                                        <td><?= $value['jumlah']; ?></td>
                                        <td><?= $value['satuan']; ?></td>
                                        <td>
                                            <?php
                                            $tanggal_kadaluarsa = $value['tanggal_kadaluarsa'];
                                            if ($tanggal_kadaluarsa >= $tanggal_sekarang) { ?>
                                                <span class="badge badge-warning">segera kadaluarsa</span><br>

                                            <?php
                                            } else if ($tanggal_kadaluarsa >= date('Y-m-d')) {
                                            ?>
                                                <span class="badge badge-warning">kadaluarsa</span><br>

                                            <?php

                                            }
                                            ?>

                                        </td>

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

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-black">Monthly Recap Report</h6>
                </div>
                <div class="card-body">
                    <input type="hidden" id="brg_masuk">
                    <input type="hidden" id="brg_keluar">
                    <div class="chart-pie pt-4">
                        <canvas id="Pie"></canvas>
                    </div>
                    <hr>
                    Styling for the donut chart can be found in the <code>/js/demo/chart-pie-demo.js</code> file.
                </div>
            </div>


        </div>

    </div>



</div>
<!---Container Fluid-->

<script>
    $(function() {
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