<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styling */
        .sidebar {
            position: fixed; /* Makes the sidebar fixed */
            top: 0;
            left: 0;
            height: 100%; /* Full height */
            width: 20vw; /* 20% width of the viewport */
            background: linear-gradient(196.32deg, #97EEC8 0.87%, #0085AA 100%);
            color: white;
            padding: 2rem 1rem;
            border-radius: 0 15px 15px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 1000;
        }
        .main-content {
            margin-left: 20vw; /* Matches the width of the sidebar */
            padding: 2rem;
        }
        .sidebar h3 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0085AA;
            margin-bottom: 2rem;
        }
        .sidebar .btn {
            background-color: transparent;
            color: white;
            border: none;
            border-radius: 10px;
            width: 100%;
            margin-bottom: 1rem;
            font-weight: bold;
            text-align: left;
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center; /* Ikon sejajar dengan teks */
            transition: all 0.3s ease;
        }
        .sidebar .btn i {
            font-size: 1.2rem; /* Ukuran ikon */
            color: white; /* Warna ikon default */
            margin-right: 0.5rem; /* Jarak antara ikon dan teks */
        }
        .sidebar .btn:hover {
            background-color: #ffffff; /* Background berubah putih saat hover */
            color: #0085AA; /* Teks berubah warna */
            transform: translateX(5px); /* Efek geser */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan */
        }
        .sidebar .btn:hover i {
            color: #0085AA; /* Ubah warna ikon saat hover */
        }
        .sidebar .btn.active {
            background-color: white;
            color: #0085AA;
            font-weight: bold;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar .btn.active i {
            color: #0085AA;
        }
        .logo {
            width: 150px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="logo img-fluid mb-3">
        <h3>Administrasi</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('admin.daftarantrian') }}" class="btn {{ Request::routeIs('admin.daftarantrian') ? 'active' : '' }}">
            <i class="bi bi-card-list"></i> Daftar Antrian
        </a>
        <a href="{{ route('admin.rekammedis') }}" class="btn {{ Request::routeIs('admin.rekammedis') ? 'active' : '' }}">
            <i class="bi bi-file-medical"></i> Rekam Medis
        </a>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
