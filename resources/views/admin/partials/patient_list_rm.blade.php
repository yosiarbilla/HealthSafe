<!-- resources/views/admin/partials/search_patient_list.blade.php -->

@forelse($data as $date => $patients)
    <!-- Display the Examination Date as a Header -->
    <h4 class="examination-date">{{ $date }}</h4>
    
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
@empty
    <p>No patients found for this search.</p>
@endforelse
