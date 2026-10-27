<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Login - Manajemen Stok SPPG</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      padding: 20px;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      background: #ffffff;
      padding: 40px 32px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .login-header {
      text-align: center;
      margin-bottom: 25px;
    }

    .login-header h1 {
      font-size: 24px;
      color: #1e293b;
      margin-bottom: 8px;
      font-weight: 700;
    }

    .login-header p {
      color: #64748b;
      font-size: 14px;
    }

    .alert {
      padding: 12px 14px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 20px;
      line-height: 1.4;
    }

    .alert-danger {
      background-color: #fef2f2;
      border: 1px solid #fecaca;
      color: #b91c1c;
    }

    .alert-success {
      background-color: #f0fdf4;
      border: 1px solid #bbf7d0;
      color: #15803d;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      color: #334155;
      font-weight: 600;
      font-size: 13px;
    }

    .form-group input {
      width: 100%;
      padding: 11px 14px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      outline: none;
      font-size: 14px;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background: #2563eb;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.2s, transform 0.1s;
      margin-top: 6px;
    }

    .btn-login:hover {
      background: #1d4ed8;
    }

    .btn-login:active {
      transform: scale(0.99);
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-header">
      <h1>Manajemen Stok SPPG</h1>
      <p>Silakan masuk menggunakan akun terdaftar</p>
    </div>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email"
          name="email" 
          value="{{ old('email') }}"
          placeholder="contoh: admin@gmail.com" 
          required
          autofocus
        >
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input 
          type="password" 
          id="password"
          name="password" 
          placeholder="Masukkan password" 
          required
        >
      </div>

      <button type="submit" class="btn-login">
        Masuk ke Sistem
      </button>
    </form>
  </div>

</body>
</html>
