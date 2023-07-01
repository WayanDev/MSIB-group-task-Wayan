@extends('layout.appadmin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
        </ol>
        @if(session('error'))
            <div class="alert alert-danger" id="error-message">
                {{ session('error') }}
            </div>
            <?php session()->forget('error'); ?>
            <script>
                setTimeout(function() {
                    document.getElementById('error-message').style.display = 'none';
                }, 3000); // Menghilangkan pesan error setelah 3 detik (3000 milidetik)
            </script>
        @endif
        <div class="row">
            <div style="margin-bottom: 20px">
                <a class="btn btn-danger" target="_blank" href="{{ route('export-dashboard-pdf-petugas') }}">
                    <i class="fas fa-file-pdf"></i> Unduh Laporan
                </a>
                <a class="btn btn-success" style="color:white" id="exportButton">
                    <i class="fas fa-file-pdf"></i> Unduh Chart
                </a>
                <strong style="font-size: 20px">{{ $tanggalDashboard }} Jam {{ $jamDashboard }}</strong>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <a class="card-body text-white" href="{{route('list_pemilih.index')}}">Total Penduduk</a>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                        <div class="text-white" style="font-size: 36px;" ><strong>{{ $total_penduduk }}</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <a class="card-body text-white" href="{{route('akun_pemilih.index')}}">Memiliki Akun</a>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                        <div class="text-white" style="font-size: 36px;" ><strong>{{ $penduduk_aktif }}</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Belum Memiliki Akun</div>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                        <div class="text-white" style="font-size: 36px;"><strong>{{ $penduduk_belum_aktif }}</strong></div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Quick Count
                </div>
                <div class="card-body">
                    <canvas id="QuickCount" width="100%" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Rentang Usia
                </div>
                <div class="card-body">
                    <canvas id="Usia" width="100%" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                                Jenis Kelamin
                        </div>
                        <div class="card-body"><canvas id="PieChartJenisKelamin" width="100%" height="50"></canvas></div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                                Status Pemilihan
                        </div>
                        <div class="card-body"><canvas id="PieChartStatus" width="100%" height="50"></canvas></div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
            </div>
    </div>
<script>
    // Fungsi untuk mengambil elemen <canvas> dan membuat PDF dari kontennya
    function exportToPDF() {
        const { jsPDF } = window.jspdf;
            // Mengatur ukuran kertas A4 landscape
        const pdf = new jsPDF('landscape', 'mm', 'a4');
        // Mengambil elemen <canvas> berdasarkan ID
        const canvas1 = document.getElementById('QuickCount');
        const canvas2= document.getElementById('Usia');
        const canvas3 = document.getElementById('PieChartJenisKelamin');
        const canvas4 = document.getElementById('PieChartStatus');

        // Mengambil gambar dari elemen <canvas> sebagai format gambar PNG
        const imageData1 = canvas1.toDataURL('image/png');
        const imageData2 = canvas2.toDataURL('image/png');
        const imageData3 = canvas3.toDataURL('image/png');
        const imageData4 = canvas4.toDataURL('image/png');

        // Menghitung posisi X dan Y untuk menempatkan gambar di tengah halaman
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imageWidth = 190; // Ukuran gambar chart
        const imageHeight = 100;

        const posX = (pageWidth - imageWidth) / 2;
        const posY = (pageHeight - imageHeight) / 2;

        // Menambahkan gambar ke dokumen PDF
        pdf.addImage(imageData1, 'PNG', posX, posY, imageWidth, imageHeight); // Mengatur posisi dan ukuran gambar di PDF
        pdf.addPage();
        pdf.addImage(imageData2, 'PNG', posX, posY, imageWidth, imageHeight);
        pdf.addPage();
        pdf.addImage(imageData3, 'PNG', posX, posY, imageWidth, imageHeight);
        pdf.addPage();
        pdf.addImage(imageData4, 'PNG', posX, posY, imageWidth, imageHeight);
        // Menyimpan dokumen PDF
        pdf.save('chart.pdf');
    }

    // Memanggil fungsi exportToPDF() saat tombol di klik
    document.addEventListener('DOMContentLoaded', function() {
        const exportButton = document.getElementById('exportButton');
        exportButton.addEventListener('click', exportToPDF);
    });
</script>
{{-- Chart untuk menampilkan hasil suara --}}
<script>
    var labelSuara = [@foreach($namaKandidat as $kandidat) '{{ $kandidat }}', @endforeach];
    var jmlSuara = [@foreach($jumlahSuara as $suara) {{ $suara }}, @endforeach];
    var persentaseSuara = [@foreach($persentaseSuara as $persentase) '{{ $persentase }}', @endforeach];

    var ctxP = document.getElementById("QuickCount").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        plugins: [ChartDataLabels],
        type: 'bar',
        data: {
            labels: labelSuara,
            datasets: [{
                data: jmlSuara,
                backgroundColor: [
                    'rgba(128,0,128)', 
                    'rgba(165,42,42)', 
                    'rgba(255,140,0)', 
                    'rgba(107,142,35)', 
                    'rgba(47,79,79)',
                    'rgba(65,105,225)', 
                ],
                hoverBackgroundColor: [
                    'rgba(255, 153, 0, 0.2)',
                    'rgba(255, 204, 0, 0.2)',
                    'rgba(0, 204, 102, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(0, 153, 255, 0.2)',
                    'rgba(255, 51, 102, 0.2)'
                ],
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'center',
                labels: {
                    padding: 20,
                    boxWidth: 10
                }
            },
            plugins: {
                datalabels: {
                    formatter: function(value, ctx) {
                        var percentage = persentaseSuara[ctx.dataIndex];
                        if (percentage === '0%') {
                            return '0%';
                        } else {
                            return value + ' (' + percentage + ')';
                        }
                    },
                    color: 'black',
                    labels: {
                        title: {
                            font: {
                                size: '16'
                            }
                        }
                    }
                }
            }
        }
    });

</script>
{{-- Chart untuk menampilkan Rentang Usia --}}
<script>
    var totalPendudukDesa = 0;
    @foreach($pemilih_per_usia as $usia)
        totalPendudukDesa += {{ $usia->total_penduduk }}; // Menghitung total penduduk di desa tersebut dengan menjumlahkan jumlah penduduk dari setiap kategori usia
    @endforeach

    var labelUsia = [@foreach($pemilih_per_usia as $usia) '{{ $usia->usia }}', @endforeach]; // Menyimpan label usia dalam array
    var jmlUsia = [@foreach($pemilih_per_usia as $usia) {{ $usia->total_penduduk }}, @endforeach]; // Menyimpan jumlah penduduk dalam array

    var persentaseUsia = jmlUsia.map(function(jumlah) {
        return ((jumlah / totalPendudukDesa) * 100).toFixed(2) + "%"; // Menghitung persentase penduduk berdasarkan total penduduk desa dan membulatkannya menjadi 2 angka desimal
    });


    var ctxP = document.getElementById("Usia").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        plugins: [ChartDataLabels],
        type: 'bar',
        data: {
            labels: labelUsia,
            datasets: [{
                data: jmlUsia,
                backgroundColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                hoverBackgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'center',
                labels: {
                    padding: 20,
                    boxWidth: 10
                }
            },
            plugins: {
                datalabels: {
                    formatter: function(value, ctx) {
                        var percentage = persentaseUsia[ctx.dataIndex];
                        var jumlah = value; // Jumlah angka
                        return jumlah + " (" + percentage + ")";
                    },
                    color: 'black',
                    labels: {
                        title: {
                            font: {
                                size: '16'
                            }
                        }
                    }
                }
            }
        }
    });
</script>
{{-- Chart untuk menampilkan Total Jenis Kelamin --}}
<script>
    // Mengubah data dari objek PHP menjadi array JavaScript
    var pieData = [];
    @foreach($jenisKelamin as $item)
        pieData.push({label: '{{ $item->jenis_kelamin }}', value: {{ $item->jumlah }}});
    @endforeach

    // Membuat array untuk labels dan data
    var labels = pieData.map(item => item.label);
    var data = pieData.map(item => item.value);

    var ctxP = document.getElementById("PieChartJenisKelamin").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        plugins: [ChartDataLabels],
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ["#5F9EA0", "#7FFF00"],
                hoverBackgroundColor: ["#00FFFF", "#006400"]
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'right',
                labels: {
                    padding: 20,
                    boxWidth: 10
                }
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        let jumlah = value; // Jumlah angka
                        return jumlah + " (" + percentage + ")";
                    },
                    color: 'black',
                    labels: {
                        title: {
                            font: {
                                size: '16'
                            }
                        }
                    }
                }
            }
        }
    });
</script>
{{-- Chart untuk menampilkan Status Pemilihan pada pemilih yang sudah memiliki akun --}}
<script>
    // Mengubah data dari objek PHP menjadi array JavaScript
    var pieData1 = [];
    @foreach($jumlahMemilih as $item)
        pieData1.push({label: '{{ $item->status }}', value: {{ $item->jumlah }}});
    @endforeach

    // Membuat array untuk labels dan data
    var labelSatus = pieData1.map(item => item.label);
    var data1 = pieData1.map(item => item.value);

    var ctxP = document.getElementById("PieChartStatus").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        plugins: [ChartDataLabels],
        type: 'pie',
        data: {
            labels: labelSatus,
            datasets: [{
                data: data1,
                backgroundColor: ["#F7464A", "#46BFBD"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"]
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'right',
                labels: {
                    padding: 20,
                    boxWidth: 10
                }
            },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        let jumlah = value; // Jumlah angka
                        return jumlah + " (" + percentage + ")";
                    },
                    color: 'black',
                    labels: {
                        title: {
                            font: {
                                size: '16'
                            }
                        }
                    }
                }
            }
        }
    });
</script>
@endsection