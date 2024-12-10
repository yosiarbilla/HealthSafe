<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
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
        .main-content {
            padding: 2rem;
            margin-left: 20vw;
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
        .user-list {
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
        .button-group button {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            @include('superadmin.sidebar')
            <div class="col main-content">
                <h1 class="dashboard-header">Daftar User</h1>

                <!-- Search Bar -->
                <div class="search-bar mb-3">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari user" onkeyup="searchUser()">
                </div>

                <!-- Add User Button -->
                <button class="btn btn-success mb-3" onclick="openAddUserModal()">Tambah User</button>

                <!-- User Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="userList">
                            @foreach($users as $index => $user)
                            <tr data-id="{{ $user->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><strong>{{ ucfirst($user->role) }}</strong></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openEditUserModal({{ $user }})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDeleteUser(event, {{ $user->id }})">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="paginationLinks">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah/Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="userId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="dokter">Dokter</option>
                            <option value="administrasi">Administrasi</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small>Isi hanya jika ingin mengubah password</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function searchUser(page = 1) {
    const searchQuery = $('#searchInput').val();
    $.ajax({
        url: "{{ route('superadmin.searchUser') }}",
        type: "GET",
        data: {
            search: searchQuery,
            page: page // Kirim nomor halaman
        },
        success: function (response) {
            if (response.success) {
                // Render hasil pencarian ke tabel
                let html = '';
                response.users.forEach((user, index) => {
                    html += `
                        <tr>
                            <td>${index + 1 + (page - 1) * 5}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td><strong>${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</strong></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="openEditUserModal(${JSON.stringify(user)})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDeleteUser(event, ${user.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                });

                $('#userList').html(html);

                // Render pagination links
                $('#paginationLinks').html(response.pagination);
            } else {
                alert('Gagal mencari user.');
            }
        },
        error: function () {
            alert('Terjadi kesalahan saat mencari user.');
        }
    });
}
$(document).on('click', '#paginationLinks a', function (e) {
    e.preventDefault();
    const page = $(this).attr('href').split('page=')[1];
    searchUser(page);
});


function openAddUserModal() {
    $('#userId').val('');
    $('#name').val('');
    $('#email').val('');
    $('#password').val('');
    $('#role').val(''); // Pastikan dropdown role kosong
    $('#userModalLabel').text('Tambah User');
    $('#userModal').modal('show');
}

function openEditUserModal(user) {
    $('#userId').val(user.id);
    $('#name').val(user.name);
    $('#email').val(user.email);
    $('#password').val('');
    $('#role').val(user.role); // Set nilai role sesuai data user
    $('#userModalLabel').text('Edit User');
    $('#userModal').modal('show');
}


function confirmDeleteUser(event, userId) {
    event.preventDefault();
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data user akan dihapus.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('superadmin.deleteUser', '') }}/" + userId,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus user.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan.');
                }
            });
        }
    });
}

$('#userForm').on('submit', function(e) {
    e.preventDefault();

    if (!$('#userId').val()) {
        $('#userId').remove();
    }

    $.ajax({
        url: "{{ route('superadmin.saveUser') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                $('#userModal').modal('hide');
                location.reload();
            } else {
                alert('Gagal menyimpan user');
            }
        },
        error: function(xhr) {
            console.error(xhr.responseJSON);
            alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
        }
    });
});
</script>
</body>
</html>
