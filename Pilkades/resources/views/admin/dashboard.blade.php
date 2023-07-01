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
                }, 3000); // Menghilangkan pesan error setelah 5 detik (5000 milidetik)
            </script>
        @endif
        <div class="row">
            <div style="margin-bottom: 20px">
                <a class="btn btn-danger" target="_blank" href="{{ route('export-dashboard-pdf') }}">
                    <i class="fas fa-file-pdf"></i> Unduh Laporan
                </a>
                <a class="btn btn-success" style="color:white" id="exportButton">
                    <i class="fas fa-file-pdf"></i> Unduh Chart
                </a>
                <strong style="font-size: 20px">{{ $tanggalDashboard }} Jam {{ $jamDashboard }}</strong>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Total Desa : {{ $list_desa }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{route('list_desa.index')}}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">Akun Desa : {{ $akun_desa }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{route('akun_desa.index')}}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Jadwal Voting : {{ $voting }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{route('jadwal_voting.index')}}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">Total Penduduk : {{ $penduduk }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{route('list_pemilih.index')}}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Jumlah Penduduk
                </div>
                <div class="card-body">
                    <canvas id="barChart" width="100%" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <script src="{{ asset('js/main.js') }}"></script>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                                Usia
                        </div>
                        <div class="card-body"><canvas id="usiaChart" width="100%" height="50"></canvas></div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                                Jenis Kelamin
                        </div>
                        <div class="card-body"><canvas id="PieChart" width="100%" height="50"></canvas></div>
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
        const canvas1 = document.getElementById('barChart');
        const canvas2= document.getElementById('usiaChart');
        const canvas3 = document.getElementById('PieChart');

        // Mengambil gambar dari elemen <canvas> sebagai format gambar PNG
        const imageData1 = canvas1.toDataURL('image/png');
        const imageData2 = canvas2.toDataURL('image/png');
        const imageData3 = canvas3.toDataURL('image/png');

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
        // Menyimpan dokumen PDF
        pdf.save('chart.pdf');
    }

    // Memanggil fungsi exportToPDF() saat tombol di klik
    document.addEventListener('DOMContentLoaded', function() {
        const exportButton = document.getElementById('exportButton');
        exportButton.addEventListener('click', exportToPDF);
    });
</script>
{{-- Chart untuk menampilkan Total Penduduk --}}
<script>
    var lbl = [@foreach($list_pemilih_per_desa as $desa) '{{ $desa->akun_desa_id }}', @endforeach];
    var jmlPemilih = [@foreach($list_pemilih_per_desa as $desa) '{{ $desa->total_pemilih }}', @endforeach];
    var jmlPemilihDenganAkun = [@foreach($list_pemilih_per_desa as $desa) '{{ $desa->total_pemilih_dengan_akun }}', @endforeach];
    var jmlPemilihTanpaAkun = [@foreach($list_pemilih_per_desa as $desa) '{{ $desa->total_pemilih - $desa->total_pemilih_dengan_akun }}', @endforeach];

    var ctxP = document.getElementById("barChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
    plugins: [ChartDataLabels],
    type: 'bar',
    data: {
        labels: lbl,
        datasets: [
        {
            label: "Total Penduduk",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: jmlPemilih,
        },
        {
            label: "Memiliki Akun",
            backgroundColor: "rgba(255,0,0,1)",
            borderColor: "rgba(255,0,0,1)",
            data: jmlPemilihDenganAkun,
        },
        {
            label: "Tidak Memiliki Akun",
            backgroundColor: "rgba(0,255,0,1)",
            borderColor: "rgba(0,255,0,1)",
            data: jmlPemilihTanpaAkun,
        }
        ],
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
                let label = '';
                if (ctx.dataset.label === "Memiliki Akun") {
                    let percentage = (value * 100 / jmlPemilih[ctx.dataIndex]).toFixed(2) + "%";
                    label = value + " (" + percentage + ")";
                } else if (ctx.dataset.label === "Tidak Memiliki Akun") {
                    let percentage = (value * 100 / jmlPemilih[ctx.dataIndex]).toFixed(2) + "%";
                    label = value + " (" + percentage + ")";
                } else {
                    label = value.toString();
                }
                return label;
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
        },
        scales: {
            x: {
                stacked: false,
            },
            y: {
                stacked: false,
                ticks: {
                    beginAtZero: true,
                    callback: (value) => {
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Format angka dengan pemisah ribuan
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
    @foreach($pemilih_per_jenis_kelamin as $item)
        pieData.push({label: '{{ $item->jenis_kelamin }}', value: {{ $item->total_pemilih }}});
    @endforeach

    // Membuat array untuk labels dan data
    var labels = pieData.map(item => item.label);
    var data = pieData.map(item => item.value);

    var ctxP = document.getElementById("PieChart").getContext('2d');
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

{{-- Chart untuk menampilkan Rentang Usia --}}
<script>
    var totalPendudukDesa = 0;
    @foreach($pemilih_per_usia as $usia)
        totalPendudukDesa += {{ $usia->total_pemilih }}; // Menghitung total penduduk di desa tersebut dengan menjumlahkan jumlah penduduk dari setiap kategori usia
    @endforeach

    var labelUsia = [@foreach($pemilih_per_usia as $usia) '{{ $usia->usia }}', @endforeach]; // Menyimpan label usia dalam array
    var jmlUsia = [@foreach($pemilih_per_usia as $usia) {{ $usia->total_pemilih }}, @endforeach]; // Menyimpan jumlah penduduk dalam array

    var persentaseUsia = jmlUsia.map(function(jumlah) {
        return ((jumlah / totalPendudukDesa) * 100).toFixed(2) + "%"; // Menghitung persentase penduduk berdasarkan total penduduk desa dan membulatkannya menjadi 2 angka desimal
    });


    var ctxP = document.getElementById("usiaChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        plugins: [ChartDataLabels],
        type: 'bar',
        data: {
            labels: labelUsia,
            datasets: [{
                label: 'Rentang Usia Semua Penduduk',
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









@endsection