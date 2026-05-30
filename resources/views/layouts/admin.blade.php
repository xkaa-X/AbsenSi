<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EduAbsen Admin</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Custom Premium Styles -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #6366f1;
            --dark-sidebar: #0f172a;
            --light-bg: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            --premium-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--light-bg);
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--dark-sidebar);
            color: #94a3b8;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 24px;
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.02);
        }

        .sidebar-brand i {
            background: var(--premium-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            padding: 20px 14px;
            list-style: none;
            margin: 0;
        }

        .sidebar-item {
            margin-bottom: 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.25s ease;
        }

        .sidebar-link i {
            font-size: 18px;
            transition: transform 0.25s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link:hover i {
            transform: scale(1.15);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: var(--premium-gradient);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        /* Main Content Wrapper */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            padding: 24px;
            padding-top: 84px; /* Space for navbar */
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: 70px;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 999;
            transition: all 0.3s ease;
        }

        /* Premium Cards */
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: var(--card-shadow);
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .stat-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        /* Tables & UI Components */
        .table-premium {
            vertical-align: middle;
        }

        .table-premium th {
            font-weight: 600;
            color: #475569;
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 16px 20px;
        }

        .table-premium td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .btn-premium-primary {
            background: var(--premium-gradient);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .btn-premium-primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .form-control-premium {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 11px 16px;
            transition: all 0.2s ease;
            font-size: 15px;
        }

        .form-control-premium:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        .form-select-premium {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 11px 16px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .form-select-premium:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        /* Badges */
        .badge-pill-premium {
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
        }

        /* Micro-animations and page loaders */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        /* Responsive elements */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -260px;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .top-navbar {
                left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Admin -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-calendar2-check-fill fs-3"></i>
            <span>EduAbsen</span>
        </div>
        <ul class="sidebar-menu">
            @if(Auth::user()->role === 'admin')
                <li class="sidebar-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ Route::is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('jurusan.index') }}" class="sidebar-link {{ Route::is('jurusan.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-bookmark-fill"></i>
                        <span>Data Jurusan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('kelas.index') }}" class="sidebar-link {{ Route::is('kelas.*') ? 'active' : '' }}">
                        <i class="bi bi-building-fill"></i>
                        <span>Data Kelas</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('siswa.index') }}" class="sidebar-link {{ Route::is('siswa.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('absensi.index') }}" class="sidebar-link {{ Route::is('absensi.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Absensi Siswa</span>
                    </a>
                </li>
            @else
                <li class="sidebar-item">
                    <a href="{{ route('siswa.dashboard') }}" class="sidebar-link {{ Route::is('siswa.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard Saya</span>
                    </a>
                </li>
            @endif
        </ul>
        
        <div class="position-absolute bottom-0 start-0 end-0 p-3">
            <div class="p-3 bg-light bg-opacity-10 rounded-4 text-center">
                <p class="text-xs mb-1 text-muted">Masuk Sebagai:</p>
                <h6 class="text-white mb-0 text-truncate">{{ Auth::user()->role === 'siswa' && Auth::user()->siswa ? Auth::user()->siswa->nama : Auth::user()->username }}</h6>
                <small class="text-white-50 d-block mb-3">({{ ucfirst(Auth::user()->role) }})</small>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Top Navbar -->
    <div class="top-navbar" id="navbar">
        <button class="btn btn-light d-lg-none" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="d-none d-md-flex align-items-center gap-2 text-muted">
            <i class="bi bi-calendar3"></i>
            <span>Hari ini: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-sm-block">
                <p class="mb-0 fw-bold text-dark">{{ Auth::user()->role === 'siswa' && Auth::user()->siswa ? Auth::user()->siswa->nama : Auth::user()->username }}</p>
                <small class="text-muted text-uppercase" style="font-size: 11px;">{{ Auth::user()->role }}</small>
            </div>
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase shadow-sm text-truncate p-1" style="width: 44px; height: 44px; font-size: 14px;">
                {{ Auth::user()->role === 'siswa' && Auth::user()->siswa ? substr(Auth::user()->siswa->nama, 0, 2) : substr(Auth::user()->username, 0, 2) }}
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container-fluid p-0 animate-fade-in">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                    <div>
                        <strong class="text-success-emphasis">Sukses!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4 p-3 d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                    <div>
                        <strong class="text-danger-emphasis">Gagal!</strong> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Main Render Section -->
            @yield('content')

        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    
    @yield('scripts')
</body>
</html>
