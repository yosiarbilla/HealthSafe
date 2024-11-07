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
            width: 20vw; /* Narrower sidebar */
            border-radius: 0 15px 15px 0; /* Adjusted for a smaller rounded edge */
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
            background-color: #e0f7fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
            color: #0085AA;
            font-weight: bold;
        }

        /* Chart styling */
        .chart-card {
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
        }

        .chart-bar span {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
         @include('admin.sidebar')

        <!-- Main content -->
        <div class="col main-content">
            <!-- Dashboard header -->
            <h1 class="dashboard-header">Dashboard</h1>

            <!-- Chart card -->
            <div class="chart-card">
                <h4>Total Pasien Mingguan</h4>
                <div class="d-flex justify-content-between align-items-end">
                    <div class="chart-bar" style="height: 80px;"><span>8</span></div>
                    <div class="chart-bar" style="height: 120px;"><span>12</span></div>
                    <div class="chart-bar" style="height: 70px;"><span>7</span></div>
                    <div class="chart-bar" style="height: 50px;"><span>5</span></div>
                    <div class="chart-bar" style="height: 140px;"><span>14</span></div>
                    <div class="chart-bar" style="height: 60px;"><span>6</span></div>
                    <div class="chart-bar" style="height: 150px;"><span>15</span></div>
                </div>
            </div>

            <!-- Cards for additional information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h5>Total Pasien</h5>
                        <p>20 Maret 2045</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h5>Jadwal Praktek</h5>
                        <p>20 Maret 2045</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
