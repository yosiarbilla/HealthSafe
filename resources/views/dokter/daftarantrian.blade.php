<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian</title>
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        /* General layout styling */
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
            overflow-y: auto;
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
        .modal-content {
            padding: 2rem;
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        @include('dokter.sidebar')
        <div class="col main-content">
            <div class="d-flex align-items-center mb-3">
                <a href="{{url('/dokter/dashboard')}}" class="d-inline-flex align-items-center mb-3 text-decoration-none">
                    <i class="back-arrow bi bi-arrow-left"></i>
                </a>
                <h1 class="dashboard-header ms-2">Daftar Antrian</h1>
            </div>
            <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" name="search" id="searchInput" placeholder="Masukkan Nama Pasien" onkeyup="searchPatient()">
            </div>
            <div class="total-count">Total Antrian: {{ $data->count() }}</div>
            <div id="patientList">
                @foreach($data as $index => $no)
                <div class="patient-list d-flex justify-content-between align-items-center" data-id="{{ $no->id }}">
                    <div class="patient-info d-flex align-items-center">
                        <span>{{ $loop->iteration }}.&nbsp;&nbsp;{{ optional($no->pasien)->nama_lengkap }}</span>
                        <span class="ms-3 badge
                            @if($no->status === 'sedang diperiksa') bg-danger
                            @elseif($no->status === 'selesai') bg-success
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($no->status) }}
                        </span>
                    </div>
                    <div class="button-group ms-auto">
                        <button class="btn btn-primary btn-sm" onclick="openExamineModal({
                            id: {{ $no->id }},
                            tanggal_pemeriksaan: '{{ \Carbon\Carbon::parse($no->tanggal_pemeriksaan)->format('d/m/Y') }}',
                            nama_lengkap: '{{ optional($no->pasien)->nama_lengkap ?? '' }}',
                            alamat: '{{ optional($no->pasien)->alamat ?? '' }}',
                            umur: '{{ optional($no->pasien)->umur ?? '' }}',
                            gender: '{{ optional($no->pasien)->gender ?? '' }}',
                            pendidikan: '{{ optional($no->pasien)->pendidikan ?? '' }}',
                            pekerjaan: '{{ optional($no->pasien)->pekerjaan ?? '' }}'
                        })">Periksa</button>
                    </div>
                </div>
                @endforeach
            </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="examineModal" tabindex="-1" aria-labelledby="examineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="examineModalLabel">Periksa Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="patientInfo">
                    <p><strong>Tanggal Pemeriksaan:</strong> <span id="tanggalPemeriksaan"></span></p>
                    <p><strong>Nama:</strong> <span id="namaPasien"></span></p>
                    <p><strong>Alamat:</strong> <span id="alamatPasien"></span></p>
                    <p><strong>Umur:</strong> <span id="umurPasien"></span></p>
                    <p><strong>Gender:</strong> <span id="genderPasien"></span></p>
                    <p><strong>Pendidikan:</strong> <span id="pendidikanPasien"></span></p>
                    <p><strong>Pekerjaan:</strong> <span id="pekerjaanPasien"></span></p>
                </div>
                <form id="examinationForm" action="{{ route('dokter.saveExamination') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="patientId"> <!-- Adjust this based on your backend requirements -->
                    <div class="mb-3">
                        <label for="keluhan" class="form-label">Keluhan</label>
                        <textarea class="form-control" id="keluhan" name="keluhan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tindakan" class="form-label">Tindakan</label>
                        <textarea class="form-control" id="tindakan" name="tindakan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="obat" class="form-label">Obat</label>
                        <input type="text" class="form-control" id="obat" name="obat" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
function searchPatient() {
    var searchQuery = $('#searchInput').val();
    $.ajax({
        url: "{{ route('dokter.search.antrian') }}",
        type: "GET",
        data: { search: searchQuery },
        success: function(response) {
            $('#patientList').html(response);
            initializeDynamicListeners();
        },
        error: function(xhr, status, error) {
            console.error("Error during search:", error);
        }
    });
}

function initializeDynamicListeners() {
    $('.patient-info').each(function(index) {
        let collapseId = $(this).data('bs-target');
        let arrowIcon = $(this).find('.chevron-icon');

        $(collapseId).on('show.bs.collapse', function() {
            arrowIcon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
        }).on('hide.bs.collapse', function() {
            arrowIcon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
        });
    });
}

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
function startExamination(patientId) {
    // Submit the form to update status and redirect
    document.getElementById('startExaminationForm' + patientId).submit();
}
function handleFormSubmit(event) {
    event.preventDefault();
    const form = event.target;

    $.ajax({
        url: form.action,
        method: 'POST',
        data: $(form).serialize(),
        success: function(response) {
            if (response.success) {
                // Hide the modal
                $('#examineModal').modal('hide');

                // Remove the patient from the list based on patient ID
                const patientId = document.getElementById('patientId').value;
                $(`#patientList .patient-list[data-id="${patientId}"]`).remove();
            } else {
                alert('Failed to save data.');
            }
        },
        error: function() {
            alert('An error occurred. Please try again.');
        }
    });
    return false;
}
function openExamineModal(patient) {
    document.getElementById('patientId').value = patient.id;
    document.getElementById('tanggalPemeriksaan').innerText = patient.tanggal_pemeriksaan;
    document.getElementById('namaPasien').innerText = patient.nama_lengkap;
    document.getElementById('alamatPasien').innerText = patient.alamat;
    document.getElementById('umurPasien').innerText = patient.umur;
    document.getElementById('genderPasien').innerText = patient.gender;
    document.getElementById('pendidikanPasien').innerText = patient.pendidikan;
    document.getElementById('pekerjaanPasien').innerText = patient.pekerjaan;

    $('#examineModal').modal('show');
}

$('#examinationForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('dokter.saveExamination') }}", // Pastikan route sudah benar
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            if (response.success) {
                $('#examineModal').modal('hide'); // Tutup modal jika berhasil

                // SweetAlert Berhasil
                Swal.fire({
                    title: "Berhasil!",
                    text: "Data pemeriksaan pasien telah disimpan.",
                    icon: "success",
                    confirmButtonText: "OK",
                }).then(() => {
                    // Refresh list antrian setelah sukses
                    location.reload();
                });
            } else {
                // SweetAlert Gagal
                Swal.fire({
                    title: "Gagal",
                    text: response.message || "Gagal menyimpan data pemeriksaan pasien.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        },
        error: function (xhr) {
            console.error("Error response:", xhr.responseText);

            // SweetAlert Error
            Swal.fire({
                title: "Kesalahan!",
                text: "Terjadi kesalahan saat menyimpan data. Silakan coba lagi.",
                icon: "error",
                confirmButtonText: "OK",
            });
        },
    });
});





</script>
</body>
</html>
