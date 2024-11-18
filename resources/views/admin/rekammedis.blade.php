<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
            position: fixed;
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
            margin-left: 20vw;
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
        .examination-date {
    font-weight: bold;
    color: #0085AA;
    margin-top: 20px;
    margin-bottom: 10px;
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
                <input type="text" name="search" id="searchInput" placeholder="Masukkan Nama Pasien" onkeyup="searchPatient2()">
            </div>

            <!-- Add Patient Button with "+" icon -->
            <button class="add-patient-btn" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                <i class="bi bi-plus-lg"></i> Tambah Pasien
            </button>



            <!-- Patient List -->
            <div id="patientList">
                @foreach($data as $date => $patients)
                    <!-- Examination Date Header -->
                    <!-- List of Patients for this Date -->
                    @foreach($patients as $patient)
                        <div class="patient-list d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#collapsePatient{{ $patient->id }}" aria-expanded="false" aria-controls="collapsePatient{{ $patient->id }}">
                            <span class="d-flex align-items-center">
                                {{ $patient->nama_lengkap }}
                                <i class="dropdown-icon bi bi-chevron-down ms-2"></i>
                            </span>
                        </div>
                        <div id="collapsePatient{{ $patient->id }}" class="collapse">
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
                <form action="{{ url('/admin/tambahpasien') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama pasien" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientAddress" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat pasien" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientAge" class="form-label">Umur</label>
                        <input type="number" class="form-control" name="umur" placeholder="Masukkan usia pasien" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientGender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender" required>
                            <option selected disabled>Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="patientEducation" class="form-label">Pendidikan</label>
                        <input type="text" class="form-control" name="pendidikan" placeholder="Masukkan pendidikan pasien" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientJob" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" placeholder="Masukkan pekerjaan pasien" required>
                    </div>
                    <div class="mb-3">
                        <label for="patientDate" class="form-label">Tanggal Pemeriksaan</label>
                        <input type="date" class="form-control" name="tanggal" placeholder="Pilih tanggal" required>
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

<script>
    function searchPatient2() {
        var searchQuery = $('#searchInput').val();

        $.ajax({
            url: "{{ route('admin.search.antrian2') }}",
            type: "GET",
            data: { search: searchQuery },
            success: function(data) {
                $('#patientList').html(data);
                reinitializeCollapse();
            }
        });
    }

    function reinitializeCollapse() {
        $('.collapse').off('show.bs.collapse hide.bs.collapse');

        $('.collapse').on('show.bs.collapse', function () {
            $(this).prev().find('.dropdown-icon').removeClass('bi-chevron-down').addClass('bi-chevron-up');
        });

        $('.collapse').on('hide.bs.collapse', function () {
            $(this).prev().find('.dropdown-icon').removeClass('bi-chevron-up').addClass('bi-chevron-down');
        });
    }

    $(document).ready(function () {
        reinitializeCollapse();
    });
</script>

<script>
    @if(session('success'))
        var toast = new bootstrap.Toast(document.getElementById('successToast'));
        toast.show();
    @endif
</script>

</body>
</html>
