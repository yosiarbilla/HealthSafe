<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pasien</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

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
            margin-bottom: 1.5rem;
            text-align: center;
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

        .main-content {
            padding: 2rem;
        }

        .back-arrow {
            font-size: 1.5rem;
            color: #0085AA;
            cursor: pointer;
        }

        .header {
            font-size: 2rem;
            font-weight: bold;
            color: #0085AA;
            text-shadow: 1px 1px #ccc;
            margin-bottom: 1.5rem;
        }

        .patient-info-card {
            background-color: #b9e8e8;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: #0085AA;
            font-weight: bold;
        }

        .patient-info-card h5 {
            margin-bottom: 0.5rem;
            color: #0085AA;
            font-size: 1.8rem;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        .patient-info-card p {
            margin: 0;
            font-size: 1rem;
            color: #004d66;
        }

        /* Collapse sections styling */
        .collapse-section {
            background-color: #a7e2e2;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #004d66;
            cursor: pointer;
            font-size: 1.2rem;
            font-family: 'Arial Rounded MT Bold', sans-serif;
        }

        
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        @include('dokter.sidebar')

        <div class="col main-content">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('dokter.rekammedis') }}" class="text-decoration-none">
                    <i class="back-arrow bi bi-arrow-left"></i>
                </a>
                <h1 class="header ms-2">Detail Pasien</h1>
            </div>

            <div class="patient-info-card">
                <h5>{{ $data->nama_lengkap }}</h5>
                <p><strong>Gender:</strong> {{ $data->gender }} &nbsp; | &nbsp; <strong>Umur:</strong> {{ $data->umur }} &nbsp; | &nbsp; <strong>Pekerjaan:</strong> {{ $data->pekerjaan }} &nbsp; | &nbsp; <strong>Pendidikan:</strong> {{ $data->pendidikan }}</p>
                <p><strong>Alamat:</strong> {{ $data->alamat }}</p>
            </div>

            <div>
                <div class="collapse-section" data-bs-toggle="collapse" data-bs-target="#record1" aria-expanded="false" aria-controls="record1">
                    <span>TGL 21/08/2024</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div id="record1" class="collapse">
                    <div class="p-3">
                        <p>Details about the examination on 21/08/2024...</p>
                    </div>
                </div>

                <div class="collapse-section" data-bs-toggle="collapse" data-bs-target="#record2" aria-expanded="false" aria-controls="record2">
                    <span>TGL 15/07/2024</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div id="record2" class="collapse">
                    <div class="p-3">
                        <p>Details about the examination on 15/07/2024...</p>
                    </div>
                </div>

                <div class="collapse-section" data-bs-toggle="collapse" data-bs-target="#record3" aria-expanded="false" aria-controls="record3">
                    <span>TGL 28/01/2023</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div id="record3" class="collapse">
                    <div class="p-3">
                        <p>Details about the examination on 28/01/2023...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
