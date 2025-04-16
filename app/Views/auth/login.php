<?= view('templates/header') ?>

<div class="max-w-md mx-auto hacker-card p-6 rounded-lg">
    <div class="text-center mb-6">
        <i class="fas fa-terminal text-4xl text-green-400 mb-2"></i>
        <h2 class="text-2xl font-bold mb-2 text-green-400 glitch-effect" data-text="GİRİŞ">GİRİŞ</h2>
        <div class="flex justify-center">
            <div class="inline-block w-16 h-1 bg-green-400 mb-4"></div>
        </div>
        <p class="text-green-300 text-sm">
            <i class="fas fa-shield-alt mr-1"></i> Güvenli erişim gerekiyor. .env dosyasında ayarlanan parolayı girin.
        </p>
    </div>
    
    <!-- Bakım Modu Uyarısı -->
    <div class="bg-green-900 text-green-200 p-3 rounded border border-green-700 mb-4">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-green-400 mr-2 text-xl"></i>
            <div>
                <div class="font-bold">BİLGİLENDİRME</div>
                <p class="text-xs">Giriş yapmadan da sistemi kullanabilirsiniz. Üst menüden 'Ana Sayfa' ya da 'Gelişmiş' bağlantılarına tıklayabilirsiniz.</p>
            </div>
        </div>
    </div>
    
    <form action="<?= base_url('auth/login') ?>" method="post" class="space-y-4">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-800 text-red-100 p-3 rounded border border-red-600 mb-4 text-sm">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="terminal-input-container">
            <label for="password" class="flex items-center text-green-400 text-sm font-bold mb-2">
                <i class="fas fa-key mr-2"></i> PAROLA
            </label>
            <div class="relative">
                <span class="absolute left-3 top-2 text-green-400">$root></span>
                <input type="password" name="password" id="password" 
                      class="hacker-input pl-16 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline focus:border-green-400"
                      required autocomplete="off">
            </div>
        </div>
        
        <div class="flex items-center justify-center mt-6">
            <button type="submit" id="loginBtn" class="hacker-btn py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                <i class="fas fa-sign-in-alt mr-2"></i> <span>TERMİNAL ERİŞİM</span>
                <span id="loadingIndicator" class="hidden ml-2">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
            </button>
        </div>
    </form>
    
    <?php if (ENVIRONMENT === 'development'): ?>
    <div class="mt-4 p-2 text-center">
        <button id="autoLoginBtn" class="bg-gray-800 text-green-400 text-xs px-3 py-1 rounded hover:bg-gray-700">
            Otomatik Giriş Dene
        </button>
    </div>
    <?php endif; ?>
    
    <div class="mt-6 text-center text-green-600 text-xs terminal-output">
        <div class="mb-1">> Şifre doğrulanıyor...</div>
        <div class="mb-1">> Sistem hazır</div>
        <div class="mb-1">> 956400 saniye oturum limiti</div>
        <div class="mb-1">> Şifre algoritması aktif</div>
        <div>> Mobil erişim hazır</div>
    </div>
    
    <?php if (ENVIRONMENT === 'development'): ?>
    <div class="mt-4 text-xs text-center text-gray-600">
        <i class="fas fa-info-circle mr-1"></i> Geliştirme modu: Varsayılan şifre "admin123" (eğer .env dosyasında ADMIN_PASSWORD ayarlanmadıysa)
    </div>
    
    <div class="mt-4 p-2 border border-gray-800 rounded bg-black text-xs text-gray-500">
        <div class="font-bold mb-1">DEBUG BİLGİSİ:</div>
        <div>Session ID: <span class="text-green-500"><?= session_id() ?></span></div>
        <div>ci_session Cookie: <span class="text-green-500"><?= isset($_COOKIE['ci_session']) ? 'VAR' : 'YOK' ?></span></div>
        <div>Oturum Durumu: <span class="text-green-500"><?= session()->get('logged_in') ? 'AKTİF' : 'PASİF' ?></span></div>
        <div>Session Path: <span class="text-green-500"><?= session_save_path() ?></span></div>
        <details>
            <summary class="cursor-pointer hover:text-green-500">Tüm Çerezler</summary>
            <pre class="text-xs text-green-700 mt-1 p-1"><?= print_r($_COOKIE, true) ?></pre>
        </details>
        <details>
            <summary class="cursor-pointer hover:text-green-500">Session Verileri</summary>
            <pre class="text-xs text-green-700 mt-1 p-1"><?= print_r($_SESSION ?? [], true) ?></pre>
        </details>
    </div>
    <?php endif; ?>
</div>

<div class="mt-8 text-center">
    <p class="text-green-500 text-sm flex justify-center">
        <i class="fas fa-arrow-left mr-2"></i>
        <a href="<?= base_url('generate') ?>" class="hover:text-green-300 border-b border-green-800">Ana sayfaya dön</a>
    </p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Terminal Efektleri
        const terminalTexts = document.querySelectorAll('.terminal-output div');
        terminalTexts.forEach((text, index) => {
            setTimeout(() => {
                text.style.display = 'block';
                // Karakter karakter animasyon ekleyebilirsiniz
            }, index * 500);
        });
        
        // Input focus efekti
        const input = document.getElementById('password');
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('border-green-400');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('border-green-400');
        });
        
        // Form gönderim efekti
        const loginForm = document.querySelector('form');
        const loginBtn = document.getElementById('loginBtn');
        const btnText = loginBtn.querySelector('span');
        const loadingIndicator = document.getElementById('loadingIndicator');
        
        loginForm.addEventListener('submit', function() {
            // Düğme metnini değiştir ve yükleme simgesini göster
            btnText.textContent = 'DOĞRULANIYOR...';
            loadingIndicator.classList.remove('hidden');
            loginBtn.classList.add('opacity-75');
            
            // Giriş gizleyerek koruma efekti
            input.disabled = true;
            
            return true;
        });
        
        // Otomatik giriş denemesi
        const autoLoginBtn = document.getElementById('autoLoginBtn');
        if (autoLoginBtn) {
            autoLoginBtn.addEventListener('click', function() {
                // Otomatik admin şifresi ekle
                input.value = '<?= getenv('ADMIN_PASSWORD') ?>';
                    
                // Cookie ayarlamayı dene
                document.cookie = "auth_test=1; path=/; max-age=86400";
                document.cookie = "byapass_session=test123; path=/; max-age=86400";
                
                // Formu gönder
                loginForm.submit();
            });
        }
        
        // Çerez kontrolü
        const checkCookies = () => {
            console.log('Mevcut Çerezler:', document.cookie);
            
            // Oturum durumunu kontrol et
            fetch('/auth/debug?format=json')
                .then(response => response.json())
                .then(data => {
                    console.log('Oturum Bilgisi:', data);
                })
                .catch(error => {
                    console.error('Oturum kontrolü başarısız:', error);
                });
        };
        
        // Sayfa yüklendiğinde çerezleri kontrol et
        checkCookies();
    });
</script>

<?= view('templates/footer') ?> 