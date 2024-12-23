<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien Mingguan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .dashboard-header {
            font-size: 2rem;
            font-weight: bold;
            color: #0085AA;
            text-shadow: 1px 1px #ccc;
            margin-bottom: 1rem;
        }

        .patient-list {
            background-color: #d6f5f7;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            color: #0085AA;
            display: flex;
            align-items: center;
        }

        .back-arrow {
            font-size: 1.5rem;
            color: #0085AA;
            cursor: pointer;
        }

        .date-summary {
            font-weight: bold;
            color: #0085AA;
            background-color: #e0f7fa;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 1rem;
            margin-top: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .date-header {
            font-size: 1.2rem;
        }

        .total-patients {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('admin.sidebar')
            <div class="col main-content">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('admin.dashboard') }}" class="d-inline-flex align-items-center mb-3 text-decoration-none">
                        <i class="back-arrow bi bi-arrow-left"></i>
                    </a>
                    <h1 class="dashboard-header">Daftar Pasien Per Minggu</h1>
                </div>
                @if($patientsByWeek->isEmpty())
                    <p class="text-muted">Tidak ada pasien yang tercatat.</p>
                @else
                    @foreach($patientsByWeek as $week => $patients)
                        <div class="date-summary">
                            <div class="date-header">{{ $week }}</div>
                            <div class="total-patients">Total Pasien: <strong>{{ $patients->count() }}</strong></div>
                        </div>
                        @foreach($patients as $patient)
                            <div class="patient-list">
                                <span>{{ $patient->nomor_antrian }}. {{ optional($patient->pasien)->nama_lengkap }}</span>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</body>
</html>
