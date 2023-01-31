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
        <!-- Donut Chart -->
        <div class="col-lg-4">
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

        <div class="col-lg-8">

        </div>
    </div>

</div>





</div>
<!---Container Fluid-->

<script>
    $(function() {
        jml_data()
        chart_line()

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

        function chart_line() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Halaman_utama/data_bulan') ?>',
                dataType: 'json',
                success: function(data) {

                    var ctx = document.getElementById("data");
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ["Januari", "Februari",
                                "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                            ],
                            datasets: [{
                                label: "Earnings",
                                lineTension: 0.3,
                                backgroundColor: "rgba(78, 115, 223, 0.5)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return '$' + number_format(value);
                                        }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                }
            })

        }

    })
</script>