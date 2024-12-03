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

        /* Sidebar styling to match Rekam Medis */
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
            top: 0;
            left: 0;
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
            margin-left: 21vw;
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

        .record-section {
            background-color: #a7e2e2;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: #004d66;
        }

        .record-header {
            font-size: 1.2rem;
            font-family: 'Arial Rounded MT Bold', sans-serif;
            color: #0085AA;
            display: flex;
            justify-content: space-between;
            cursor: pointer;
        }

        .record-details {
            margin-top: 1rem;
        }

        .record-detail-item {
            background-color: white;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            height: 100px;
            overflow-y: auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .record-detail-label {
            font-weight: bold;
            color: #0085AA;
            margin-bottom: 5px;
        }

        .record-detail-content {
            color: #004d66;
            height: calc(100% - 25px);
            overflow-y: auto;
        }

        .download-button {
            background-color: #0085AA;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar with updated styling to match Rekam Medis -->
        @include('dokter.sidebar')

        <!-- Main content -->
        <div class="col main-content">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('dokter.rekammedis') }}" class="text-decoration-none">
                    <i class="back-arrow bi bi-arrow-left"></i>
                </a>
                <h1 class="header ms-2">Detail Pasien</h1>
            </div>

            <!-- Patient Information Card -->
            <div class="patient-info-card">
                <h5>{{ $data->nama_lengkap }}</h5>
                <p><strong>Gender:</strong> {{ $data->gender }} &nbsp; | &nbsp; <strong>Umur:</strong> {{ $data->umur }} &nbsp; | &nbsp; <strong>Pekerjaan:</strong> {{ $data->pekerjaan }} &nbsp; | &nbsp; <strong>Pendidikan:</strong> {{ $data->pendidikan }}</p>
                <p><strong>Alamat:</strong> {{ $data->alamat }}</p>
            </div>

            <!-- Rekam Medis -->
            @if($data->rekamMedis->isNotEmpty())
                @foreach($data->rekamMedis as $record)
                    <div class="record-section">
                    <div class="record-header" data-bs-toggle="collapse" data-bs-target="#record{{ $record->id }}" aria-expanded="false" aria-controls="record{{ $record->id }}">
                        <span>TGL {{ \Carbon\Carbon::parse($record->tanggal_pemeriksaan)->format('d/m/Y') }}</span>
                        <div>
                            <button class="btn btn-primary btn-sm me-2" onclick="editRecord({{ $record->id }})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <i id="arrowIcon{{ $record->id }}" class="bi bi-chevron-down chevron-icon ms-2"></i>
                        </div>
                    </div>

                        <div id="record{{ $record->id }}" class="collapse">
                            <div class="record-details">
                                <div class="record-detail-label">Keluhan</div>
                                <div class="record-detail-item">
                                    <div class="record-detail-content">{{ $record->keluhan }}</div>
                                </div>

                                <div class="record-detail-label">Diagnosis</div>
                                <div class="record-detail-item">
                                    <div class="record-detail-content">{{ $record->diagnosis }}</div>
                                </div>

                                <div class="record-detail-label">Tindakan</div>
                                <div class="record-detail-item">
                                    <div class="record-detail-content">{{ $record->tindakan }}</div>
                                </div>

                                <div class="record-detail-label">Obat</div>
                                <div class="record-detail-item">
                                    <div class="record-detail-content">{{ $record->obat }}</div>
                                </div>
                            </div>
                            <button class="download-button" onclick="downloadPDF(
                                '{{ $data->nama_lengkap }}',
                                '{{ \Carbon\Carbon::parse($record->tanggal_pemeriksaan)->format('d/m/Y') }}',
                                '{{ $record->keluhan }}',
                                '{{ $record->diagnosis }}',
                                '{{ $record->tindakan }}',
                                '{{ $record->obat }}'
                            )">Download PDF</button>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No examination records available for this patient.</p>
            @endif

        </div>
    </div>
</div>

<div class="modal fade" id="editRecordModal" tabindex="-1" aria-labelledby="editRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRecordModalLabel">Edit Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRecordForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        {{-- <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pemeriksaan</label>
                            <input type="date" class="form-control" name="tanggal_pemeriksaan" id="edit_tanggal_pemeriksaan" required>
                        </div> --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Keluhan</label>
                            <textarea class="form-control" name="keluhan" id="edit_keluhan" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Diagnosis</label>
                            <textarea class="form-control" name="diagnosis" id="edit_diagnosis" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tindakan</label>
                            <textarea class="form-control" name="tindakan" id="edit_tindakan" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Obat</label>
                            <textarea class="form-control" name="obat" id="edit_obat" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    function downloadPDF(patientName, date, keluhan, diagnosis, tindakan, obat) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFont('helvetica', 'bold');

        doc.setFontSize(16);
        doc.text("REKAM MEDIS PASIEN", 105, 20, { align: 'center' });
        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        doc.text("APOTEK SETIA BUDI", 105, 28, { align: 'center' });
        doc.text("Alamat: ", 105, 35, { align: 'center' });

        doc.setLineWidth(0.5);
        doc.line(20, 40, 190, 40);

        doc.setFont('helvetica', 'bold');
        doc.text("Identitas Pasien", 20, 50);
        doc.setFont('helvetica', 'normal');
        doc.text(`Nama Pasien: ${patientName}`, 20, 58);
        doc.text(`Tanggal Pemeriksaan: ${date}`, 20, 66);

        doc.setLineWidth(0.5);
        doc.line(20, 72, 190, 72);

        doc.setFont('helvetica', 'bold');
        doc.text("Detail Pemeriksaan", 20, 82);

        doc.setFont('helvetica', 'bold');
        doc.text("Keluhan:", 20, 92);
        doc.setFont('helvetica', 'normal');
        doc.text(keluhan, 30, 100, { maxWidth: 170 });

        doc.setFont('helvetica', 'bold');
        doc.text("Diagnosis:", 20, 120);
        doc.setFont('helvetica', 'normal');
        doc.text(diagnosis, 30, 128, { maxWidth: 170 });

        doc.setFont('helvetica', 'bold');
        doc.text("Tindakan:", 20, 148);
        doc.setFont('helvetica', 'normal');
        doc.text(tindakan, 30, 156, { maxWidth: 170 });

        doc.setFont('helvetica', 'bold');
        doc.text("Obat:", 20, 176);
        doc.setFont('helvetica', 'normal');
        doc.text(obat, 30, 184, { maxWidth: 170 });

        doc.setFont('helvetica', 'italic');
        doc.setFontSize(10);
        doc.text("Dokumen Rekam Medis - Rahasia Medis", 105, 280, { align: 'center' });

        doc.setFontSize(10);
        doc.text(`Halaman 1 dari 1`, 190, 290, { align: 'right' });

        doc.save(`Rekam_Medis_${patientName}_${date}.pdf`);
    }
    function editRecord(recordId) {
        fetch(`/dokter/rekam-medis/${recordId}/edit`)
            .then(response => response.json())
            .then(data => {
                // document.getElementById('edit_tanggal_pemeriksaan').value = data.tanggal_pemeriksaan;
                document.getElementById('edit_keluhan').value = data.keluhan;
                document.getElementById('edit_diagnosis').value = data.diagnosis;
                document.getElementById('edit_tindakan').value = data.tindakan;
                document.getElementById('edit_obat').value = data.obat;

                document.getElementById('editRecordForm').action = `/dokter/rekam-medis/${recordId}`;

                var editModal = new bootstrap.Modal(document.getElementById('editRecordModal'));
                editModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengambil data rekam medis');
            });
    }

</script>
<script>
    // Tambahkan event listener setelah DOM selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil semua elemen dengan class "record-header"
        const recordHeaders = document.querySelectorAll(".record-header");

        // Tambahkan event listener untuk setiap record-header
        recordHeaders.forEach(header => {
            const chevronIcon = header.querySelector(".chevron-icon"); // Ambil chevron-icon di dalam header
            const targetId = header.getAttribute("data-bs-target"); // Ambil ID target collapse
            const targetCollapse = document.querySelector(targetId); // Temukan elemen collapse target

            // Event saat collapse ditampilkan
            targetCollapse.addEventListener("show.bs.collapse", function() {
                chevronIcon.classList.remove("bi-chevron-down");
                chevronIcon.classList.add("bi-chevron-up");
            });

            // Event saat collapse disembunyikan
            targetCollapse.addEventListener("hide.bs.collapse", function() {
                chevronIcon.classList.remove("bi-chevron-up");
                chevronIcon.classList.add("bi-chevron-down");
            });
        });
    });
</script>

</body>
</html>
