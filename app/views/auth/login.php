<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SI-PASTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #006b3c; /* Hijau Zamrud UMI  */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .btn-umi {
            background-color: #006b3c;
            color: white;
            border: none;
        }
        .btn-umi:hover {
            background-color: #004d2c;
            color: #d4af37; /* Aksen Emas [cite: 30] */
        }
        .logo-section img {
            width: 80px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-card text-center">
    <div class="logo-section">
        <h5 class="fw-bold">Sistem Informasi Akuntansi</h5>
        <p class="text-muted small">BSU Kema Pertika</p>
    </div>

    <form action="index.php?page=auth_process" method="POST" class="text-start mt-4">
        <div class="mb-3">
            <label class="form-label small fw-bold">Username</label> 
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                <input type="text" name="username" class="form-control border-start-0 bg-light" placeholder="Masukkan username" required>
            </div>
        </div>
        <div class="mb-4">
           <label class="form-label small fw-bold">Password</label> 
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control border-start-0 bg-light" placeholder="Masukkan password" required>
            </div>
        </div>
        <button type="submit" class="btn btn-umi w-100 py-2 fw-bold">
            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
        </button>
    </form>

    <div class="mt-4">
        <p class="text-muted" style="font-size: 0.7rem;">&copy; 2025 BSU Kema Pertika - UMI</p>
    </div>
</div>

</body>
</html>