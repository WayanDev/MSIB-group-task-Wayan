<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pilkades - Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>


</head>

<body class="sb-nav-fixed">
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-primary navbar-dark px-2 py-4">
        <div class="container px-5">
            <a class="navbar-brand fw-semibold" href="#">Pilkades</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <ul class="navbar-nav me-0 mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link active" aria-current="page" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#qc">QuickCount</a>
                    </li>
                    <li>
                        <a class="btn btn-primary ms-4" href="{{ route('login') }}" style="padding: .4rem 1rem;">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i> Login</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="layoutSidenav_content">
        @if (session('error'))
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
        <div class="container px-4 py-5">
            {{-- Hero Section --}}
            <div class="row mb-4 align-items-center flex-lg-row-reverse">
                <div class="col-md-6 col-xl-7 mb-4 mb-lg-0 " id="about">
                    <div class="lc-block position-relative p-4"><img class="img-fluid rounded"
                            src="{{ asset('photos/hero.jpg') }}" sizes="(max-width: 3840px) 100vw, 3840px" width="3840"
                            height="" alt="Hero">
                    </div>
                </div>
                <div class="col-md-6 col-xl-5">
                    <div class="lc-block mb-3">
                        <div editable="rich">
                            <h1 class="display-2" style="font-weight: 800"> E-Voting Kepala Desa</h1>
                        </div>
                    </div>
                    <div class="lc-block mb-4">
                        <div editable="rich">
                            <p class="lead">Selamat datang di Pilkades, Anda dapat melihat hasil voting pada halaman
                                ini, klik login untuk memilih kandidat</p>
                        </div>
                    </div>
                    <div class="lc-block">
                        <a class="btn btn-lg btn-primary" href="{{ route('login') }}" role="button">Click Here to Login</a>
                    </div>
                </div>
            </div>


            {{-- Quick Count --}}
            <div class="row mt-5 justify-content-md-center" id="qc">
                @foreach ($dataPerDesa as $data)
                @if (is_array($data))
                <div class="col-lg-6 my-5">
                    <div class="text-center">
                        <h1 class="text-primary" style="font-weight: 900">Quick Count Desa {{ $data['desaNama'] }}
                        </h1>
                        <p class="text-secondary">Desa {{ $data['desaNama'] }}</p>
                    </div>
                    <div class="border p-4 rounded">
                        <canvas id="QuickCount_{{ str_replace(' ', '_', $data['desaNama']) }}" width="100%"
                            height="50"></canvas>
                        <script>
                            var labelSuara_{{ str_replace(' ', '_', $data['desaNama']) }} = [
                                    @foreach ($data['namaKandidat'] as $kandidat)
                                        '{{ $kandidat }}',
                                    @endforeach
                                ];
                                var jmlSuara_{{ str_replace(' ', '_', $data['desaNama']) }} = [
                                    @foreach ($data['jumlahSuara'] as $suara)
                                        {{ $suara }},
                                    @endforeach
                                ];
                                var persentaseSuara_{{ str_replace(' ', '_', $data['desaNama']) }} = [
                                    @foreach ($data['persentaseSuara'] as $persentase)
                                        '{{ $persentase }}',
                                    @endforeach
                                ];

                                var ctxP_{{ str_replace(' ', '_', $data['desaNama']) }} = document.getElementById(
                                    "QuickCount_{{ str_replace(' ', '_', $data['desaNama']) }}").getContext('2d');
                                var myPieChart_{{ str_replace(' ', '_', $data['desaNama']) }} = new Chart(
                                    ctxP_{{ str_replace(' ', '_', $data['desaNama']) }}, {
                                        plugins: [ChartDataLabels],
                                        type: 'bar',
                                        data: {
                                            labels: labelSuara_{{ str_replace(' ', '_', $data['desaNama']) }},
                                            datasets: [{
                                                data: jmlSuara_{{ str_replace(' ', '_', $data['desaNama']) }},
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
                                                        var percentage = persentaseSuara_{{ str_replace(' ', '_', $data['desaNama']) }}[ctx
                                                            .dataIndex];
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
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <footer class="py-4 bg-primary mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-light" style="color:white;">Copyright &copy; Pilkades 2023</div>
                    <div style="color:white;">
                        <a href="#" style="color:white;">Privacy Policy</a>
                        &middot;
                        <a href="#" style="color:white;">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/assets/demo/chart-bar-demo.js') }}"></script>
    <script src="{{ asset('admin/assets/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>