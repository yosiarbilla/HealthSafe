<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
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
            width: 100px;
            margin-bottom: 1rem;
        }

        .sidebar h3 {
            font-size: 1rem;
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

        /* Main content styling */
        .main-content {
            padding: 2rem;
        }

        .back-arrow {
            font-size: 1.5rem;
            color: #0085AA;
            cursor: pointer;
        }

        .dashboard-header {
            font-size: 2rem;
            font-weight: bold;
            color: #0085AA;
            text-shadow: 1px 1px #ccc;
            margin-bottom: 1rem;
        }

        .search-bar {
            border-radius: 20px;
            background-color: #e0f7fa;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            max-width: 500px;
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            padding-left: 0.5rem;
        }

        .search-bar i {
            color: #0085AA;
        }

        /* Patient list styling */
        .patient-list {
            background-color: #d6f5f7;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            color: #0085AA;
        }

        .patient-list p {
            margin: 0;
        }

        .total-count {
            font-weight: bold;
            color: #0085AA;
            background-color: #e0f7fa;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Add Patient Button */
        .add-patient-btn {
            background-color: #00C6FF;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            font-weight: bold;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-patient-btn:hover {
            background-color: #0072ff;
        }
        .modal-xl {
            max-width: 800px; /* Increase the width of the modal */
        }
        .modal-content {
            padding: 2rem;
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-auto sidebar d-flex flex-column align-items-center">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="logo img-fluid">
            <h3>Administrasi</h3>
            <a href="#" class="btn">Daftar Antrian</a>
            <a href="#" class="btn">Rekam Medis</a>
        </div>

        <!-- Main content -->
        <div class="col main-content">
            <!-- Back arrow and Header -->
            <div class="d-flex align-items-center mb-3">
            <a href="{{url('/admin/dashboard')}}" class="d-inline-flex align-items-center mb-3 text-decoration-none">
            <i class="back-arrow bi bi-arrow-left"></i>
            </a>
                <h1 class="dashboard-header ms-2">Daftar Antrian</h1>
            </div>

            <!-- Search bar -->
            <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Masukkan Nama Pasien">
            </div>

            <!-- Add Patient Button with "+" icon -->
            <button class="add-patient-btn" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                <i class="bi bi-plus-lg"></i> Tambah Pasien
            </button>

            <!-- Total Count -->
            <div class="total-count">Total Antrian: 3</div>

            <!-- Patient List -->
            <div class="patient-list">Bpk. Mulyono Yudha</div>
            <div class="patient-list">Bpk. Susilo Benjamin</div>
            <div class="patient-list">Bpk. Budiono Siregar</div>
        </div>
    </div>
</div>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Tambah Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" id="patientName" placeholder="Masukkan nama pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientAge" class="form-label">Usia</label>
                        <input type="number" class="form-control" id="patientAge" placeholder="Masukkan usia pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientNotes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="patientNotes" placeholder="Catatan tambahan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
