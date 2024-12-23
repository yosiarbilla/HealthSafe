<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian</title>

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
            overflow-y:auto;
            position:fixed;
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
            margin-left:20vw;
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
            display: flex;
            align-items: center;
        }

        .patient-list .patient-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
            cursor: pointer;
        }

        .patient-list .chevron-icon {
            margin-left: 8px;
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
        .suggestion-box {
    background-color: #d6f5f7;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 10px;
    position: absolute;
    top: 130px; /* Adjust this based on the position */
    z-index: 10;
    width: 90%; /* To match the width of the search bar */
    max-height: 150px;
    max-width: 400px;
    overflow-y: auto;
    display: none; /* This will be set to display:block dynamically */
}

.suggestion-item {
    padding: 8px;
    cursor: pointer;
    color: #0085AA;
    font-weight: bold;
}

.suggestion-item:hover {
    background-color: #e0f7fa;
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
                <h1 class="dashboard-header ms-2">Daftar Antrian</h1>
            </div>

            <!-- Search bar -->
            <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" name="search" id="searchInput" placeholder="Masukkan Nama Pasien" onkeyup="searchPatient()">

            </div>


            <!-- Add Patient Button with "+" icon -->
            <div id="suggestions" class="suggestion-box"></div>
            <!-- Total Count -->

            <div class="total-count">Total Antrian: {{ $data->count() }}</div>

            <!-- Patient List -->
            <div id="patientList">
                @foreach($data as $index => $queue)
                <div class="patient-list d-flex justify-content-between align-items-center">
                    <!-- Informasi Pasien dengan Chevron -->
                    <div class="patient-info d-flex align-items-center" data-bs-toggle="collapse" data-bs-target="#collapsePatient{{ $index }}" aria-expanded="false" aria-controls="collapsePatient{{ $index }}">
                        <span>{{ $queue->nomor_antrian }}.&nbsp;&nbsp; {{ optional($queue->pasien)->nama_lengkap }}</span>

                        <span class="ms-3 badge
                            @if($queue->status === 'sedang diperiksa') bg-danger
                            @elseif($queue->status === 'selesai') bg-success
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($queue->status) }}
                        </span>
                        <i id="arrowIcon{{ $index }}" class="bi bi-chevron-down chevron-icon ms-2"></i>
                    </div>
                    <div class="button-group ms-auto">
                        <button class="btn btn-info btn-sm" onclick="confirmInProgress(event, {{ $queue->id }})">Ubah Status</button>
                        <form action="{{ route('admin.markAsInProgress', $queue->id) }}" method="POST" id="inProgressForm{{ $queue->id }}" style="display: none;">
                            @csrf
                            @method('PUT')
                        </form>

                        <button class="btn btn-success btn-sm" onclick="confirmMarkAsCompleted(event, {{ $queue->id }})">Selesai</button>
                        <form id="markAsCompletedForm{{ $queue->id }}" action="{{ route('admin.markAsCompleted', $queue->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                        </form>

                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editPatientModal{{ $index }}">Edit</button>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.delete.antrian', $queue->id) }}" method="POST" style="display:inline;" id="deleteForm{{ $queue->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmation(event, {{ $queue->id }})">Delete</button>
                        </form>
                    </div>
                </div>
                <div id="collapsePatient{{ $index }}" class="collapse">
                    <div class="p-3 bg-light rounded">
                        <p><strong>Nama:</strong> {{ optional($queue->pasien)->nama_lengkap }}</p>
                        <p><strong>Alamat:</strong> {{ optional($queue->pasien)->alamat }}</p>
                        <p><strong>Umur:</strong> {{ optional($queue->pasien)->umur }}</p>
                        <p><strong>Gender:</strong> {{ optional($queue->pasien)->gender }}</p>
                        <p><strong>Pendidikan:</strong> {{ optional($queue->pasien)->pendidikan }}</p>
                        <p><strong>Pekerjaan:</strong> {{ optional($queue->pasien)->pekerjaan }}</p>
                    </div>
                </div>
                <div class="modal fade" id="editPatientModal{{ $index }}" tabindex="-1" aria-labelledby="editPatientModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPatientModalLabel{{ $index }}">Edit Pasien</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form Edit Pasien -->
                                <form action="{{ route('admin.edit.antrian', $queue->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="editName" class="form-label">Nama Pasien</label>
                                        <input type="text" class="form-control" name="nama" value="{{ optional($queue->pasien)->nama_lengkap }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editAddress" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" value="{{ optional($queue->pasien)->alamat }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editAge" class="form-label">Umur</label>
                                        <input type="number" class="form-control" name="umur" value="{{ optional($queue->pasien)->umur }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editGender" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="gender" required>
                                            <option value="Laki-laki" {{ optional($queue->pasien)->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ optional($queue->pasien)->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editEducation" class="form-label">Pendidikan</label>
                                        <input type="text" class="form-control" name="pendidikan" value="{{ optional($queue->pasien)->pendidikan }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editJob" class="form-label">Pekerjaan</label>
                                        <input type="text" class="form-control" name="pekerjaan" value="{{ optional($queue->pasien)->pekerjaan }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editDate" class="form-label">Tanggal Pemeriksaan</label>
                                        <input type="date" class="form-control" name="tanggal_pemeriksaan" value="{{ optional($queue->pasien)->tanggal_pemeriksaan }}" required>
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>
        </div>
    </div>
</div>



<script>
$(document).on('click', '.patient-info', function () {
        const collapseId = $(this).attr('data-bs-target');
        const chevronIcon = $(this).find('.chevron-icon');
        const isExpanded = $(this).attr('aria-expanded') === 'true';

        // Toggle collapse manually
        if (isExpanded) {
            $(collapseId).collapse('hide');
            $(this).attr('aria-expanded', 'false');
            chevronIcon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
        } else {
            $(collapseId).collapse('show');
            $(this).attr('aria-expanded', 'true');
            chevronIcon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
        }
    });

    // Synchronize chevron icon on collapse events
    $('.collapse').on('shown.bs.collapse', function () {
        const chevronIcon = $(`[data-bs-target="#${this.id}"]`).find('.chevron-icon');
        const toggleButton = $(`[data-bs-target="#${this.id}"]`);
        chevronIcon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
        toggleButton.attr('aria-expanded', 'true');
    });

    $('.collapse').on('hidden.bs.collapse', function () {
        const chevronIcon = $(`[data-bs-target="#${this.id}"]`).find('.chevron-icon');
        const toggleButton = $(`[data-bs-target="#${this.id}"]`);
        chevronIcon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
        toggleButton.attr('aria-expanded', 'false');
    });
function searchPatient() {
    let searchQuery = $('#searchInput').val();

    if (searchQuery.length > 0) {
        $.ajax({
            url: "{{ route('admin.search.suggestions') }}", // Adjust this route to match your backend
            type: "GET",
            data: { search: searchQuery },
            success: function(data) {
                let suggestionsBox = $('#suggestions');
                suggestionsBox.empty();

                if (data.length > 0) {
                    data.forEach(patient => {
                        suggestionsBox.append(`<div class="suggestion-item" onclick="selectPatient('${patient.nama_lengkap}', ${patient.id})">${patient.nama_lengkap}</div>`);
                    });
                    suggestionsBox.show();
                } else {
                    suggestionsBox.hide();
                }
            }
        });
    } else {
        $('#suggestions').hide();
    }
}

function selectPatient(name, id) {
    console.log("Selected Patient Name:", name);
    console.log("Selected Patient ID:", id);

    if (!id) {
        swal("Gagal", "ID pasien tidak valid.", "error");
        return;
    }

    $('#searchInput').val(name); // Set nama di input pencarian
    $('#suggestions').hide(); // Sembunyikan suggestion box

    // Kirim request ke server
    $.ajax({
        url: "{{ url('/admin/tambahantrian') }}",
        type: "POST",
        data: {
            id: id, // Kirim ID pasien
            _token: '{{ csrf_token() }}' // Sertakan CSRF token
        },
        success: function(response) {
            if (response.success) {
                swal("Berhasil", response.message, "success");
                location.reload(); // Reload halaman
            } else {
                swal("Gagal", response.message, "error");
            }
        },
        error: function(xhr) {
            let errorResponse = JSON.parse(xhr.responseText);
            if (errorResponse.errors && errorResponse.errors.id) {
                swal("Gagal", errorResponse.errors.id[0], "error");
            } else {
                swal("Gagal", "Terjadi kesalahan tidak terduga.", "error");
            }
        }
    });
}


function initializeDynamicListeners() {
    // Toggle dropdown functionality
    $(document).on('click', '.patient-info', function () {
        const collapseId = $(this).attr('data-bs-target');
        const chevronIcon = $(this).find('.chevron-icon');

        // Toggle collapse
        $(collapseId).collapse('toggle');

        // Synchronize chevron icon
        $(collapseId).on('shown.bs.collapse', function () {
            chevronIcon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
        });

        $(collapseId).on('hidden.bs.collapse', function () {
            chevronIcon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
        });
    });


    // Delete confirmation with SweetAlert
    $('.btn-danger').off('click').on('click', function(event) {
        event.preventDefault();
        let form = $(this).closest('form'); // Find the closest form to the delete button

        swal({
            title: "Are you sure you want to delete this record?",
            text: "This action cannot be undone.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
}

// Initialize listeners on page load and after each search
$(document).ready(function() {
    initializeDynamicListeners();
});


function confirmMarkAsCompleted(event, patientId) {
    event.preventDefault();
    swal({
        title: "Apakah Anda yakin?",
        text: "Setelah ditandai selesai, pasien akan dihapus dari antrian.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willMarkAsCompleted) => {
        if (willMarkAsCompleted) {
            document.getElementById('markAsCompletedForm' + patientId).submit();
        }
    });
}

function confirmInProgress(event, patientId) {
    event.preventDefault();
    swal({
        title: "Apakah Anda yakin?",
        text: "Pasien akan ditandai sebagai sedang diperiksa.",
        icon: "info",
        buttons: true,
    }).then((willProceed) => {
        if (willProceed) {
            document.getElementById('inProgressForm' + patientId).submit();
        }
    });
}

function addToQueue(patientName) {
    $.ajax({
        url: "{{ url('/admin/tambahantrian') }}", // Use the existing "tambahantrian" route
        type: "POST",
        data: {
            name: patientName,
            _token: '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function(response) {
            if (response.success) {
                swal("Success", patientName + " has been added to the queue.", "success");
                // Optionally, update the queue list to reflect the new addition
            } else {
                swal("Error", "Failed to add " + patientName + " to the queue.", "error");
            }
        },
        error: function(error) {
            swal("Error", "An error occurred while adding to the queue.", "error");
        }
    });
}

</script>



<script type="text/javascript">
    function confirmation(ev, patientId) {
        ev.preventDefault();  // Mencegah pengiriman form secara langsung

        swal({
            title: "Apakah Anda Yakin Untuk Menghapus Ini?",
            text: "Anda Tidak Bisa Mengembalikannya",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Kirim form setelah konfirmasi
                document.getElementById('deleteForm' + patientId).submit();
            }
        });
    }
</script>



</body>
</html>
