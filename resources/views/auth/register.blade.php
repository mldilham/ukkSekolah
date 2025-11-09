<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Member - MarSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #28a745, #20c997);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: #fff;
            animation: fadeIn 0.6s ease;
        }

        .card-header {
            border-bottom: none;
            background: transparent;
            text-align: center;
        }

        .card-header h4 {
            font-weight: 600;
            color: #fff;
        }

        .form-label {
            color: #fff;
            font-weight: 500;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .btn-success {
            border-radius: 10px;
            font-weight: 500;
            padding: 10px;
            background: linear-gradient(90deg, #28a745, #20c997);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(90deg, #218838, #17a589);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
        }

        .card-footer {
            background: transparent;
            border-top: none;
            color: #f8f9fa;
        }

        .card-footer a {
            color: #ffd700;
            text-decoration: none;
            font-weight: 500;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-10px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="card-header">
                        <h4><i class="fas fa-user-plus me-2"></i> Registrasi Member</h4>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                       id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kontak" class="form-label">Kontak (No. HP)</label>
                                <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                       id="kontak" name="kontak" value="{{ old('kontak') }}" required>
                                @error('kontak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                       id="username" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-user-plus"></i> Daftar
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-center">
                        <p class="mb-0">Sudah punya akun?
                            <a href="{{ route('login') }}">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
