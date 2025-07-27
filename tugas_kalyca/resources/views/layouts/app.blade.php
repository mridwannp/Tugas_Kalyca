<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Toko</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(160deg, #212529, #343a40);
            color: white;
            min-height: 100vh;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            margin-left: -250px;
        }

        .sidebar .brand {
            font-size: 1.4rem;
            font-weight: bold;
            padding: 1rem;
            text-align: center;
            background-color: #1c1f23;
            border-bottom: 1px solid #444;
        }

        .sidebar a {
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.25s ease;
            font-size: 0.95rem;
        }

        .sidebar a:hover {
            background-color: #495057;
            border-left: 4px solid #0d6efd;
        }

        .sidebar a.active {
            background-color: #0d6efd;
            border-left: 4px solid #ffffff;
            color: white;
        }

        .content {
            flex-grow: 1;
            transition: all 0.3s ease;
        }

        .navbar-custom {
            background-color: white;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toggle-btn {
            font-size: 1.3rem;
            background: none;
            border: none;
            color: #212529;
        }

        .dropdown .dropdown-menu {
            font-size: 0.9rem;
        }

        .sidebar i {
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div id="sidebar" class="sidebar">
        <div class="brand">
            <a href="{{ route('dashboard') }}" style="color: white; text-decoration: none;">
                <i class="fas fa-store"></i> Gudang Baju Anak
            </a>
        </div>
        <a href="{{ route('masukan.index') }}" class="{{ request()->is('masukan*') ? 'active' : '' }}">
            <i class="fas fa-arrow-circle-down"></i> Masukan
        </a>
        <a href="{{ route('pengeluaran.index') }}" class="{{ request()->is('pengeluaran*') ? 'active' : '' }}">
            <i class="fas fa-arrow-circle-up"></i> Keluaran
        </a>
        <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Laporan
        </a>
    </div>

    <div id="mainContent" class="content w-100">
        <nav class="navbar-custom">
            <button class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></button>

            <div class="dropdown">
                <a href="#" class="dropdown-toggle text-dark text-decoration-none" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i> Admin
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="p-4">
            @yield('content')
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });
</script>
@stack('scripts')
</body>
<footer class="text-center mt-2 mb-1">
    <small>&copy; {{ date('Y') }} Gudang Baju Anak. All rights reserved.</small>
</footer>
</html>
