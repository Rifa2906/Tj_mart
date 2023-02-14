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
    <!--Row-->
    <div class="row">
        <div class="col-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="chart-pie pt-">
                        <canvas id="Pie"></canvas>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-circle text-primary"></i> barang masuk
                        </div>
                        <div class="col-6">
                            <i class="fas fa-circle text-success"></i> barang keluar
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>





</div>
<!---Container Fluid-->

<script>
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

                    bm = data.brg_masuk;
                    bk = data.brg_keluar;

                    // Pie Chart Example
                    var ctx = document.getElementById("Pie");
                    var myPieChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ["Barang Masuk", "Barang Keluar"],
                            datasets: [{
                                data: [bm, bk],
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
                }
            })
        }





    })
</script>