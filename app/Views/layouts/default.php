<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByaPass - Güvenli Şifre Oluşturucu</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        .card {
            background-color: #1e293b;
            border: 1px solid #334155;
        }
        .card-header {
            background-color: #10b981;
        }
        .btn-primary {
            background-color: #10b981;
            border-color: #059669;
        }
        .btn-primary:hover {
            background-color: #059669;
            border-color: #047857;
        }
        .form-control {
            background-color: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }
        .form-control:focus {
            background-color: #1e293b;
            color: #e2e8f0;
            border-color: #10b981;
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <header class="text-center mb-5">
            <h1 class="display-5 fw-bold text-white">
                <i class="fas fa-shield-alt text-success me-2"></i>ByaPass
            </h1>
            <p class="text-muted">Güvenli Şifre Yöneticisi</p>
        </header>
        
        <?= $this->renderSection('content') ?>
        
        <footer class="mt-5 text-center text-muted">
            <p><small>&copy; <?= date('Y') ?> ByaPass - Tüm hakları saklıdır.</small></p>
        </footer>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 