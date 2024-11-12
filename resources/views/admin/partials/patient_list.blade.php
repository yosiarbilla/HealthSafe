@foreach($data as $index => $patient)
                <div class="patient-list d-flex justify-content-between align-items-center">
                <!-- Informasi Pasien dengan Chevron -->
                    <div class="patient-info d-flex align-items-center" data-bs-toggle="collapse" data-bs-target="#collapsePatient{{ $index }}" aria-expanded="false" aria-controls="collapsePatient{{ $index }}">
                        <span>{{ $loop->iteration }}.&nbsp;&nbsp; {{$patient->nama_lengkap}}</span>
                        <!-- Ikon Chevron -->
                         <span class="ms-3 badge 
                @if($patient->status === 'sedang diperiksa') bg-danger 
                @elseif($patient->status === 'selesai') bg-success 
                @else bg-secondary 
                @endif">
                {{ ucfirst($patient->status) }}
            </span>
                        <i id="arrowIcon{{ $index }}" class="bi bi-chevron-down chevron-icon ms-2"></i>
                    </div>
                        <div class ="button-group ms-auto">
                        

                        <button class="btn btn-info btn-sm" onclick="confirmInProgress(event, {{ $patient->id }})">Ubah Status</button> &nbsp;&nbsp;
                            <form action="{{ route('admin.markAsInProgress', $patient->id) }}" method="POST" id="inProgressForm{{ $patient->id }}" style="display: none;">
                                @csrf
                                @method('PUT')
                            </form>

                        <button class="btn btn-success btn-sm" onclick="confirmMarkAsCompleted(event, {{ $patient->id }})">Selesai </button> &nbsp;&nbsp;
                            <form id="markAsCompletedForm{{ $patient->id }}" action="{{ route('admin.markAsCompleted', $patient->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                            </form>


                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editPatientModal{{ $index }}">Edit</button>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('admin.delete.antrian', $patient->id) }}" method="POST" style="display:inline;" id="deleteForm{{ $patient->id }}">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmation(event, {{ $patient->id }})">Delete</button>
</form>
                        </div>
                    </div>

                    <!-- Patient Details Collapse -->
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

                    <!-- Edit Patient Modal -->
                    <div class="modal fade" id="editPatientModal{{ $index }}" tabindex="-1" aria-labelledby="editPatientModalLabel{{ $index }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPatientModalLabel{{ $index }}">Edit Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.edit.antrian', $patient->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="editName" class="form-label">Nama Pasien</label>
                                            <input type="text" class="form-control" name="nama" value="{{ $patient->nama_lengkap }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editAddress" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" value="{{ $patient->alamat }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editAge" class="form-label">Umur</label>
                                            <input type="number" class="form-control" name="umur" value="{{ $patient->umur }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editGender" class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" name="gender" required>
                                                <option value="Laki-laki" {{ $patient->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ $patient->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editEducation" class="form-label">Pendidikan</label>
                                            <input type="text" class="form-control" name="pendidikan" value="{{ $patient->pendidikan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editJob" class="form-label">Pekerjaan</label>
                                            <input type="text" class="form-control" name="pekerjaan" value="{{ $patient->pekerjaan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editDate" class="form-label">Tanggal Pemeriksaan</label>
                                            <input type="date" class="form-control" name="tanggal_pemeriksaan" value="{{ $patient->tanggal_pemeriksaan }}" required>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <script>

function searchPatient() {
    var searchQuery = $('#searchInput').val();

    $.ajax({
        url: "{{ route('admin.search.antrian') }}",
        type: "GET",
        data: { search: searchQuery },
        success: function(response) {
            // Replace the patient list with the new partial content
            $('#patientList').html(response);

            // Reinitialize event listeners for dynamic content
            initializeDynamicListeners();
        },
        error: function(xhr, status, error) {
            console.error("Error during search:", error);
        }
    });
}

function initializeDynamicListeners() {
    // Collapse toggle event listener for chevron icon
    $('.patient-info').off('click').on('click', function() {
        let collapseId = $(this).attr('data-bs-target');
        let arrowIcon = $(this).find('.chevron-icon');

        // Toggle icon based on collapse status
        $(collapseId).on('shown.bs.collapse', function() {
            arrowIcon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
        });

        $(collapseId).on('hidden.bs.collapse', function() {
            arrowIcon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
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
    
    
