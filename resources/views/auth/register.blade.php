<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Member - MarSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 420px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            padding: 30px 25px 20px;
        }

        .card-header h4 {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .card-header p {
            color: #718096;
            font-size: 14px;
            margin: 0;
        }

        .card-body {
            padding: 25px;
        }

        .form-label {
            color: #4a5568;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #e53e3e;
            background-image: none;
        }

        .invalid-feedback {
            display: block;
            color: #e53e3e;
            font-size: 13px;
            margin-top: 5px;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 10px;
            font-weight: 500;
            padding: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #17a589 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-success:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .alert-success {
            background: #f0fff4;
            color: #276749;
            border: 1px solid #9ae6b4;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
            text-align: center;
        }

        .card-footer p {
            color: #718096;
            font-size: 14px;
            margin: 0;
        }

        .card-footer a {
            color: #28a745;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .card-footer a:hover {
            color: #20c997;
            text-decoration: underline;
        }

        /* Input field hover effect */
        .form-control:hover {
            border-color: #cbd5e0;
        }

        /* Button focus effect */
        .btn-success:focus {
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card-header {
                padding: 25px 20px 15px;
            }

            .card-body {
                padding: 20px;
            }

            .card-footer {
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-user-plus"></i>
                    Registrasi Member
                </h4>
                <p>Buat akun baru Anda</p>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <script>
                        Swal.fire({
                            title: "Registrasi Gagal!",
                            text: "{{ $errors->first() }}",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    </script>
                @endif

                @if(session('success'))
                    <script>
                        Swal.fire({
                            title: "Registrasi Berhasil!",
                            text: "{{ session('success') }}",
                            icon: "success",
                            confirmButtonText: "OK"
                        });
                    </script>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text"
                               class="form-control @error('nama') is-invalid @enderror"
                               id="nama"
                               name="nama"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kontak" class="form-label">Kontak (No. HP)</label>
                        <input type="text"
                               class="form-control @error('kontak') is-invalid @enderror"
                               id="kontak"
                               name="kontak"
                               value="{{ old('kontak') }}"
                               placeholder="Masukkan nomor HP"
                               required>
                        @error('kontak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               id="username"
                               name="username"
                               value="{{ old('username') }}"
                               placeholder="Masukkan username"
                               required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Masukkan password"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Konfirmasi password"
                               required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i>Daftar
                    </button>
                </form>
            </div>

            <div class="card-footer">
                <p class="mb-0">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
