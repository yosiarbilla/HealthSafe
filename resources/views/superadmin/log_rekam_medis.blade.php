<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Rekam Medis</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-header {
            font-size: 2rem;
            font-weight: bold;
            color: #0077b6;
            margin-bottom: 1rem;
        }

        .table-container {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .back-arrow {
            font-size: 1.5rem;
            color: #0077b6;
            cursor: pointer;
        }

        .table th {
            background-color: #0077b6;
            color: #fff;
        }

        .table td {
            vertical-align: middle;
        }

        .filter-section {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pagination {
            margin-top: 1rem;
        }

        .text-danger {
            font-weight: bold;
        }

        .text-success {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('superadmin.sidebar')
            <div class="col main-content">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('superadmin.dashboard') }}" class="d-inline-flex align-items-center mb-3 text-decoration-none">
                        <i class="back-arrow bi bi-arrow-left"></i>
                    </a>
                    <h1 class="dashboard-header">Log Rekam Medis</h1>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <form class="d-flex" method="GET" action="{{ route('superadmin.logRekamMedis') }}">
                        <input type="text" name="doctor_name" class="form-control me-2" placeholder="Cari Nama Dokter" value="{{ request('doctor_name') }}">
                        <input type="date" name="date" class="form-control me-2" value="{{ request('date') }}">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>

                <!-- Table Container -->
                <div class="table-container">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dokter</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Perubahan</th>
                                <th>Detail Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $index => $log)
                                <tr>
                                    <td>{{ $logs->firstItem() + $index }}</td>
                                    <td>{{ $log->dokter->name ?? 'Tidak diketahui' }}</td>
                                    <td>{{ $log->rekamMedis->pasien->nama_lengkap ?? 'Tidak diketahui' }}</td>
                                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach(json_decode($log->changes, true) as $field => $change)
                                                @if(is_array($change) && isset($change['old'], $change['new']) && $change['old'] !== $change['new'])
                                                    <li>
                                                        <strong>{{ ucfirst($field) }}</strong>:
                                                        <span class="text-danger">{{ $change['old'] }}</span>
                                                        <i class="bi bi-arrow-right"></i>
                                                        <span class="text-success">{{ $change['new'] }}</span>
                                                    </li>
                                                @endif
                                            @endforeach

                                            @if(empty(array_filter(json_decode($log->changes, true), function($change) {
                                                return is_array($change) && isset($change['old'], $change['new']) && $change['old'] !== $change['new'];
                                            })))
                                                <li class="text-muted">Tidak ada perubahan yang signifikan.</li>
                                            @endif
                                        </ul>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada log rekam medis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $logs->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
