
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #chart-container {
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Selamat Datang, <?= $username ?>!</h1>
        
        <div class="row">
            <!-- Total Alumni Card -->
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Alumni</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalAlumni ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alumni per Jurusan Cards -->
            <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">RPL (Rekayasa Perangkat Lunak)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= isset(array_column($alumniByJurusan, 'count', 'jurusan')['RPL']) ? array_column($alumniByJurusan, 'count', 'jurusan')['RPL'] : 0 ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user-graduate fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>


            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">AKL (Akuntansi Keuangan Lembaga)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= isset(array_column($alumniByJurusan, 'count', 'jurusan')['AKL']) ? array_column($alumniByJurusan, 'count', 'jurusan')['AKL'] : 0 ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">BDP (Bisnis Daring dan Pemasaran)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= isset(array_column($alumniByJurusan, 'count', 'jurusan')['BDP']) ? array_column($alumniByJurusan, 'count', 'jurusan')['BDP'] : 0 ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart Card -->
            <div class="col-xl-6 mb-4">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Jumlah Alumni per Jurusan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2>Daftar Alumni Terbaru</h2>
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Alumni</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>NIS</th>
                            <th>Tahun Lulus</th>
                            <th>Pekerjaan</th>
                            <th>Perusahaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alumniList as $alumni): ?>
                        <tr>
                            <td><?= $alumni->nama_alumni; ?></td>
                            <td><?= $alumni->jurusan; ?></td>
                            <td><?= $alumni->NIS; ?></td>
                            <td><?= $alumni->tahun_lulus; ?></td>
                            <td><?= $alumni->pekerjaan; ?></td>
                            <td><?= $alumni->perusahaan; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const ctx = document.getElementById('myBarChart').getContext('2d');

        // Filter hanya untuk jurusan RPL, BDP, dan AKL
        const jurusanFilter = ['RPL', 'BDP', 'AKL'];
        const alumniData = <?= json_encode($alumniByJurusan) ?>;

        const filteredAlumniCount = jurusanFilter.map(jurusan => {
            const alumni = alumniData.find(item => item.jurusan === jurusan);
            return alumni ? alumni.count : 0; // Jika tidak ada alumni, kembalikan 0
        });

        const myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: jurusanFilter,
        datasets: [{
            // Menghapus label untuk menghilangkan kotak warna
            label: '', // Kosongkan label di sini
            data: filteredAlumniCount,
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
            ],
            borderColor: 'rgba(255, 255, 255, .6)',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Alumni'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Jurusan'
                }
            }
        },
        plugins: {
            legend: {
                display: false, // Sembunyikan legenda
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw; // Tampilkan label dan nilai
                    }
                }
            }
        }
    }
});

    </script>
</body>
