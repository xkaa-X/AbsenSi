<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduAbsen</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgb(239, 246, 255) 0%, rgb(219, 234, 254) 90%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background Elements */
        .decor-blob-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(180deg, rgba(79, 70, 229, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%);
            border-radius: 50%;
            position: absolute;
            top: -100px;
            left: -100px;
            filter: blur(80px);
            z-index: 0;
        }

        .decor-blob-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(180deg, rgba(6, 182, 212, 0.12) 0%, rgba(59, 130, 246, 0.12) 100%);
            border-radius: 50%;
            position: absolute;
            bottom: -150px;
            right: -100px;
            filter: blur(100px);
            z-index: 0;
        }

        /* Card login wrapper */
        .login-card {
            background-color: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
            z-index: 10;
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            padding: 30px 30px 15px 30px;
            text-align: center;
        }

        .login-logo {
            width: 52px;
            height: 52px;
            background: var(--primary-gradient);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-bottom: 15px;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        .login-body {
            padding: 0 30px 30px 30px;
        }

        .form-control-premium {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 15px;
            background-color: rgba(255, 255, 255, 0.6);
            transition: all 0.2s ease;
        }

        .form-control-premium:focus {
            border-color: #4f46e5;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .input-group-text-premium {
            background-color: transparent;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #94a3b8;
            padding-left: 16px;
        }

        .input-premium-right {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .btn-premium-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .btn-premium-primary:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.35);
        }

        /* Demo badge details */
        .demo-credentials-card {
            background-color: rgba(79, 70, 229, 0.05);
            border: 1px dashed rgba(79, 70, 229, 0.25);
            border-radius: 16px;
            padding: 16px;
            font-size: 13.5px;
        }
    </style>
</head>
<body>

    <!-- Blobs -->
    <div class="decor-blob-1"></div>
    <div class="decor-blob-2"></div>

    <!-- Login Container -->
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-calendar2-check-fill"></i>
            </div>
            <h3 class="fw-extrabold text-dark mb-1">Selamat Datang</h3>
            <p class="text-muted mb-0">Website Pendataan & Absensi Siswa</p>
        </div>

        <div class="login-body">
            
            <!-- Alert Session Flash -->
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm p-3 mb-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
                    <div style="font-size: 14px;">{{ session('success') }}</div>
                </div>
            @endif

            <!-- Alert Validation Errors -->
            @if($errors->has('loginError'))
                <div class="alert alert-danger border-0 rounded-4 shadow-sm p-3 mb-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-danger"></i>
                    <div style="font-size: 14px;">{{ $errors->first('loginError') }}</div>
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf
                
                <!-- Username Input -->
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold" style="font-size: 14px;">Username</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-premium"><i class="bi bi-person-fill"></i></span>
                        <input type="text" class="form-control form-control-premium input-premium-right @error('username') is-invalid @enderror" 
                               id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold" style="font-size: 14px;">Password</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-premium"><i class="bi bi-shield-lock-fill"></i></span>
                        <input type="password" class="form-control form-control-premium input-premium-right @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Masukkan password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Button -->
                <button type="submit" class="btn btn-premium-primary w-100 mb-4">
                    Login Ke Sistem <i class="bi bi-arrow-right-short fs-5 ms-1"></i>
                </button>
            </form>

            <!-- Test Credentials Card -->
            <div class="demo-credentials-card">
                <div class="d-flex align-items-center mb-2 text-indigo-800">
                    <i class="bi bi-info-circle-fill me-2 text-primary fs-5"></i>
                    <span class="fw-bold text-primary">Akun Seeder Default:</span>
                </div>
                <div class="mb-2 pb-2 border-bottom">
                    <small class="d-block text-muted fw-bold">GURU (TEACHER):</small>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Username:</span>
                        <strong class="text-dark">guru</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Password:</span>
                        <strong class="text-dark">guru123</strong>
                    </div>
                </div>
                <div>
                    <small class="d-block text-muted fw-bold">SISWA:</small>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Username (NIS):</span>
                        <strong class="text-dark">1 s/d 40</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Password:</span>
                        <strong class="text-dark">siswa123</strong>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
