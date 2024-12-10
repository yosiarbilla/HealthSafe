<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General layout styling */
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        /* Sidebar styling */
        .sidebar {
            background: linear-gradient(196.32deg, #97EEC8 0.87%, #0085AA 100%);
            color: white;
            padding: 2rem 1rem;
            height: 100vh;
            width: 20vw;
            border-radius: 0 15px 15px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            width: 150px;
            margin-bottom: 1.5rem;
        }

        .sidebar h3 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0085AA;
            margin-bottom: 2rem;
            text-align: center; /* Center text */
        }

        .sidebar .btn {
            background-color: #e0f7fa;
            color: #0085AA;
            border: none;
            border-radius: 10px;
            width: 100%;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        /* Main content styling */
        .main-content {
            padding: 2rem;
        }

        .dashboard-header {
            font-size: 2rem;
            font-weight: bold;
            color: #0085AA;
            text-shadow: 1px 1px #ccc;
            margin-bottom: 1.5rem;
        }

        /* Card styling */
        .card {
            border-radius: 20px;
            background-color: #e0f7fa !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
            color: #0085AA;
            font-weight: bold;
        }
        .card p{
            text-align: start;
            color: #0085AA;
            font-weight: bold;
        }
        .card a{
            text-align: start;
            color: #0085AA;
            font-weight: bold;
            bottom: 10px;
            right: 10px;
            text-transform: none;
            text-decoration: none;
            font-size: 1rem
        }
        .card h5{
            text-align: start;
            color: #0085AA;
            font-weight: bold;
            font-size: 3rem
        }

        /* Chart styling */
        .chart-card {
            height: 350px;
            overflow-y: auto;
            border-radius: 20px;
            background-color: #d6f5f7;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        /* Chart data */
        .chart-bar {
            display: inline-block;
            width: 14%;
            margin: 0 0.5%;
            background-color: #0085AA;
            color: white;
            border-radius: 5px;
            position: relative;
            text-align: center;
            font-size: 0.9rem;
            height: calc(10px + 10%);
            min-height: 50px;
        }
        .chart-card h4 {
            text-align: start;
            color: #0085AA;
            font-weight: bold;
            font-size: 2rem;
            text-transform: none;
            text-decoration: none;
        }
        .chart-card h4 a {
            color: #0085AA !important;
            text-decoration: none;
            font-weight: bold;
        }

        .chart-card h4 a:hover {
            color: #005F73 !important;
            text-decoration: underline;
        }

        .chart-bar span {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
        }
        .d-flex.align-items-end {
            align-items: flex-end;
            height: 250px;
            position: relative;
            border-radius: 10px;
            padding: 10px 0;
        }

    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
         @include('superadmin.sidebar')

        <!-- Main content -->
        <div class="col main-content">
            <!-- Dashboard header -->
            <h1 class="dashboard-header">Dashboard</h1>

            <!-- Chart card -->
            <div class="chart-card">
                <h4>
                    <a href="{{ route('superadmin.patients.weekly') }}" class="text-decoration-none text-primary">
                        Total Pasien Mingguan
                    </a>
                </h4>
                <div class="d-flex justify-content-between align-items-end">
                    @foreach($pasienMingguan as $data)
                        <div class="chart-bar" style="height: {{ $data->total * 10 }}px;">
                            <span>{{ $data->total }}</span>
                            <p>{{ \Carbon\Carbon::parse($data->date)->format('d M') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Cards for additional information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h5>Total Pasien</h5>
                        <p style="font-size: 2rem">{{ $todayDate }}</p>
                        <p style="font-size: 5rem">{{ $totalPasienHariIni }}</p>
                        <a href="{{ route('superadmin.patients.today') }}" class="position-absolute" >Detail >></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h5>Jadwal Praktek</h5>
                        <p style="font-size: 2rem">{{ $todayDate }}</p>
                        <p style="font-size: 5rem"> 08:00 - 16:00</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
