@forelse($data as $patient)
    <div class="patient-list d-flex justify-content-between align-items-center" data-id="{{ $patient->id }}">
        <span>{{ $patient->nama_lengkap }}</span>
        <a href="{{ route('admin.detail.pasien', ['id' => $patient->id]) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
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
@empty
    <p>No patients found for this search.</p>
@endforelse
