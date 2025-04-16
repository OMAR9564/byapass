<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Giriş</h3>
                </div>
                <div class="card-body">
                    <div id="error-message" class="alert alert-danger d-none" role="alert"></div>
                    
                    <form id="login-form">
                        <div class="mb-3">
                            <label for="password" class="form-label">Yönetici Şifresi</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text text-muted">
                                Erişim için yönetici şifresini giriniz.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="spinner"></span>
                                Giriş Yap
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');
    const spinner = document.getElementById('spinner');
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Hata mesajını temizle
        errorMessage.classList.add('d-none');
        errorMessage.textContent = '';
        
        // Spinner'ı göster
        spinner.classList.remove('d-none');
        
        const password = document.getElementById('password').value;
        
        fetch('<?= base_url('login/authenticate') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                'password': password
            })
        })
        .then(response => response.json())
        .then(data => {
            // Spinner'ı gizle
            spinner.classList.add('d-none');
            
            if (data.error) {
                // Hata mesajını göster
                errorMessage.textContent = data.error;
                errorMessage.classList.remove('d-none');
            } else if (data.success) {
                // Başarılı giriş, generate sayfasına yönlendir
                window.location.href = '<?= base_url('generate') ?>';
            }
        })
        .catch(error => {
            // Spinner'ı gizle
            spinner.classList.add('d-none');
            
            // Genel hata mesajı göster
            errorMessage.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
            errorMessage.classList.remove('d-none');
            console.error('Error:', error);
        });
    });
});
</script>

<?= $this->endSection() ?> 