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
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div id="record{{ $record->id }}" class="collapse">
                            <div class="record-details">
                                <p><strong>Keluhan:</strong> {{ $record->keluhan }}</p>
                                <p><strong>Diagnosis:</strong> {{ $record->diagnosis }}</p>
                                <p><strong>Obat:</strong> {{ $record->obat }}</p>
                                <button class="download-button" onclick="downloadPDF('{{ $record->tanggal_pemeriksaan }}', '{{ $record->keluhan }}', '{{ $record->diagnosis }}', '{{ $record->obat }}')">Download PDF</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No examination records available for this patient.</p>
            @endif

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    function downloadPDF(date, keluhan, diagnosis, obat) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Set PDF title
        doc.setFontSize(18);
        doc.text("Detail Pasien", 10, 10);

        // Examination details
        doc.setFontSize(12);
        doc.text(`Tanggal Pemeriksaan: ${date}`, 10, 20);
        doc.text("Keluhan:", 10, 30);
        doc.text(keluhan, 20, 40);
        doc.text("Diagnosis:", 10, 50);
        doc.text(diagnosis, 20, 60);
        doc.text("Obat:", 10, 70);
        doc.text(obat, 20, 80);

        // Save the PDF
        doc.save(`Detail_Pemeriksaan_${date}.pdf`);
    }
</script>

</body>
</html>
