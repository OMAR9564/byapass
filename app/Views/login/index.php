<?= view('templates/header') ?>

<?= csrf_field() ?>
<div class="max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-green-400 glitch-effect" data-text="YÖNETİCİ GİRİŞİ">YÖNETİCİ GİRİŞİ</h2>
    
    <div class="flex justify-center mb-4">
        <div class="inline-block w-16 h-1 bg-green-400"></div>
    </div>
    
    <p class="mb-6 text-green-300 text-sm">
        <i class="fas fa-info-circle mr-1"></i> Şifre yöneticisine erişim için yönetici şifrenizi girin.
    </p>
    
    <div id="error-message" class="mb-4 p-3 bg-red-900 border border-red-600 rounded-lg text-red-200 text-sm hidden">
        <i class="fas fa-exclamation-circle mr-2"></i> <span id="error-text"></span>
    </div>
    
    <form id="login-form" class="space-y-4">
        <div class="terminal-input-container">
            <label for="password" class="flex items-center text-green-400 text-sm font-bold mb-2">
                <i class="fas fa-key mr-2"></i> YÖNETİCİ ŞİFRESİ
            </label>
            <div class="relative">
                <input type="hidden" name="csrf_token" value="<?= csrf_hash() ?>" />
                <span class="absolute left-3 top-2 text-green-400">$></span>
                <input type="password" name="password" id="password" 
                      class="hacker-input pl-10 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline focus:border-green-400"
                      required>
            </div>
            <p class="text-xs text-green-600 mt-1 flex items-center">
                <i class="fas fa-lock mr-1"></i> Güvenli erişim sağlanacak
            </p>
        </div>
        
        <div class="flex items-center justify-center">
            <button type="submit" class="hacker-btn py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                <span id="button-text"><i class="fas fa-sign-in-alt mr-2"></i> GİRİŞ YAP</span>
                <span id="spinner" class="hidden">
                    <i class="fas fa-circle-notch fa-spin mr-2"></i> İŞLENİYOR...
                </span>
            </button>
        </div>
    </form>
</div>

<div class="mt-8 max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h3 class="text-xl font-bold mb-4 text-center text-green-400 flex items-center justify-center">
        <i class="fas fa-shield-alt mr-2"></i> Güvenlik Bilgisi
    </h3>
    
    <p class="text-green-300 text-sm">
        Bu sisteme sadece yetkili personel erişebilir. Tüm giriş denemeleri kaydedilmektedir. 
        Şifre yöneticinize erişim sağladıktan sonra her site için benzersiz şifreler oluşturabilirsiniz.
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Hata mesajını temizle
        errorMessage.classList.add('hidden');
        errorText.textContent = '';
        
        // Yükleme durumunu göster
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');
        
        // CSRF token doğrudan sayfadan al
        const csrfName = document.querySelector('input[type="hidden"][name]').name; 
        const csrfValue = document.querySelector('input[type="hidden"][name]').value;
        
        const password = document.getElementById('password').value;
        
        const formData = new FormData();
        formData.append('password', password);
        formData.append(csrfName, csrfValue);
        
        fetch('<?= base_url('login/authenticate') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Yükleme durumunu gizle
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
            
            if (data.message) {
                // Hata mesajını göster
                errorText.textContent = data.message;
                errorMessage.classList.remove('hidden');
                
                // Şifre alanını sallayarak hata efekti ver
                const passwordInput = document.getElementById('password');
                passwordInput.classList.add('border-red-500');
                passwordInput.classList.add('shake-animation');
                
                setTimeout(() => {
                    passwordInput.classList.remove('shake-animation');
                }, 500);
            } else if (data.success) {
                // Başarılı giriş, generate sayfasına yönlendir
                console.log("Başarılı giriş, sayfa yönlendiriliyor...");
                setTimeout(function() {
                    window.location.href = '<?= base_url('generate') ?>';
                }, 500);
            }
        })
        .catch(error => {
            // Yükleme durumunu gizle
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
            
            // Genel hata mesajını göster
            errorText.textContent = 'Bağlantı hatası. Lütfen tekrar deneyin.';
            errorMessage.classList.remove('hidden');
            console.error('Error:', error);
        });
    });
    
    // Input alanları için terminal efekti
    const inputs = document.querySelectorAll('.hacker-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('border-green-400');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('border-green-400');
        });
    });
});

// Terminal yazı efekti
const addTextGlitchEffect = () => {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const passwordInput = document.getElementById('password');
    
    passwordInput.addEventListener('input', function() {
        let i = 0;
        const interval = setInterval(() => {
            const randomChar = chars.charAt(Math.floor(Math.random() * chars.length));
            this.value = this.value.substring(0, i) + randomChar + this.value.substring(i + 1);
            i++;
            
            if (i >= this.value.length) {
                clearInterval(interval);
            }
        }, 50);
    });
};

// CSS animasyon
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .shake-animation {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
    </style>
`);
</script>

<?= view('templates/footer') ?> 