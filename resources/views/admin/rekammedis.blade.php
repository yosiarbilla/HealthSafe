<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis</title>
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

        .modal-content {
            padding: 2rem;
            border-radius: 15px;
        }

        /* Toast styling for top-center positioning */
        .toast-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 11;
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
            <!-- Back arrow and Header -->
            <div class="d-flex align-items-center mb-3">
                <a href="{{url('/admin/dashboard')}}" class="d-inline-flex align-items-center mb-3 text-decoration-none">
                    <i class="back-arrow bi bi-arrow-left"></i>
                </a>
                <h1 class="dashboard-header ms-2">Rekam Medis</h1>
            </div>

            <!-- Search bar -->
            <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" name="search" id="searchInput" placeholder="Masukkan Nama Pasien" onkeyup="searchPatient()"  >
                </form>
            </div>

            <!-- Add Patient Button with "+" icon -->
            <button class="add-patient-btn" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                <i class="bi bi-plus-lg"></i> Tambah Pasien
            </button>

            <!-- Total Count -->
            <div class="total-count">Total Antrian: {{ $data->count() }}</div>

            <!-- Patient List -->
            <div id="patientList">
            @foreach($data as $index => $patient)
                <div class="patient-list " data-bs-toggle="collapse" data-bs-target="#collapsePatient{{ $index }}" aria-expanded="false" aria-controls="collapsePatient{{ $index }}">
                <span>{{ $loop->iteration }}.&nbsp;&nbsp; {{$patient->nama_lengkap}}   </span>
                    <i class="dropdown-icon bi bi-chevron-down collapsed"></i>
                </div>
                <div id="collapsePatient{{ $index }}" class="collapse">
                    <div class="p-3">
                        <p><strong>Tanggal Pemeriksaan:</strong> {{ \Carbon\Carbon::parse($patient->tanggal_pemeriksaan)->format('d/m/Y') }}</p>
                        <p><strong>Nama:</strong> {{ $patient->nama_lengkap }}</p>
                        <p><strong>Alamat:</strong> {{ $patient->alamat }}</p>
                        <p><strong>Umur:</strong> {{ $patient->umur }}</p>
                        <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                        <p><strong>Pendidikan:</strong> {{ $patient->pendidikan }}</p>
                        <p><strong>Pekerjaan:</strong> {{ $patient->pekerjaan }}</p>
                    </div>
                </div>
                @endforeach
    </div>
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
                <form action="{{ url('/admin/tambahantrian') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientAddress" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientAge" class="form-label">Umur</label>
                        <input type="number" class="form-control" name="umur" placeholder="Masukkan usia pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientGender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender">
                            <option selected disabled>Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="patientEducation" class="form-label">Pendidikan</label>
                        <input type="text" class="form-control" name="pendidikan" placeholder="Masukkan pendidikan pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientJob" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" placeholder="Masukkan pekerjaan pasien">
                    </div>
                    <div class="mb-3">
                        <label for="patientDate" class="form-label">Tanggal Pemeriksaan</label>
                        <input type="date" class="form-control" name="tanggal" placeholder="Pilih tanggal">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast Notification -->
<div class="toast-container">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Data berhasil ditambahkan!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function searchPatient() {
        var searchQuery = $('#searchInput').val();

        $.ajax({
            url: "{{ route('admin.search.antrian') }}",  // Replace with the correct route
            type: "GET",
            data: { search: searchQuery },
            success: function(data) {
                $('#patientList').html(data);
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    @if(session('success'))
        var toast = new bootstrap.Toast(document.getElementById('successToast'))
        toast.show();
    @endif
</script>

</body>
</html>
