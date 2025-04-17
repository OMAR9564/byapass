<?= view('templates/header') ?>

<div class="max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-green-400 glitch-effect" data-text="ŞİFRE ÜRETEÇ">ŞİFRE ÜRETEÇ</h2>

    <div class="flex justify-center mb-4">
        <div class="inline-block w-16 h-1 bg-green-400"></div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-4 p-3 bg-green-900 border border-green-600 rounded-lg text-green-200 text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-3 bg-red-900 border border-red-600 rounded-lg text-red-200 text-sm">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <p class="mb-6 text-green-300 text-sm">
        <i class="fas fa-info-circle mr-1"></i> Ana şifrenizi ve site adını girerek her site için benzersiz bir şifre oluşturun. 
        Şifreleriniz .env dosyasında güvenli bir şekilde saklanır.
    </p>

    <form id="passwordForm" class="space-y-4">
        <input type="hidden" id="csrf"  name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
        
        <div class="terminal-input-container">
            <label for="master_password" class="flex items-center text-green-400 text-sm font-bold mb-2">
                <i class="fas fa-key mr-2"></i> ANA ŞİFRE
            </label>
            <div class="relative">
                <span class="absolute left-3 top-2 text-green-400">$></span>
                <input type="password" name="master_password" id="master_password" 
                       class="hacker-input pl-10 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline focus:border-green-400"
                       required>
            </div>
            <p class="text-xs text-green-600 mt-1 flex items-center">
                <i class="fas fa-lock mr-1"></i> Bu şifreyi iyi hatırlayın, hiçbir yere kaydetmeyin!
            </p>
        </div>

        <div class="terminal-input-container">
            <label for="site_name" class="flex items-center text-green-400 text-sm font-bold mb-2">
                <i class="fas fa-globe mr-2"></i> SİTE ADI
            </label>
            <div class="relative">
                <span class="absolute left-3 top-2 text-green-400">@></span>
                <input type="text" name="site_name" id="site_name" 
                       class="hacker-input pl-10 shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline focus:border-green-400"
                       required placeholder="örn: facebook.com">
            </div>
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" class="hacker-btn py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                <i class="fas fa-cog fa-spin mr-2"></i> ŞİFRE OLUŞTUR
            </button>
        </div>
    </form>

    <!-- Yükleme Göstergesi -->
    <div id="loadingIndicator" class="mt-4 text-center hidden">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-green-500 border-r-2 border-green-300"></div>
        <p class="mt-2 text-green-400 text-sm">Şifre oluşturuluyor...</p>
    </div>

    <div id="passwordResult" class="mt-6 p-4 bg-gray-900 border border-green-500 rounded-lg hidden">
        <h3 class="text-lg font-bold mb-2 text-green-400 flex items-center">
            <i class="fas fa-check-circle mr-2"></i> Oluşturulan Şifre:
        </h3>
        <div class="flex">
            <input type="text" id="generatedPassword" 
                   class="hacker-input shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline bg-black"
                   readonly>
            <button id="copyButton" class="hacker-btn py-2 px-4 rounded ml-2">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <p class="text-xs text-green-600 mt-2 flex items-center">
            <i class="fas fa-check-circle mr-1"></i> Bu şifre .env dosyasına kaydedildi.
        </p>
    </div>
</div>

<div class="mt-8 max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h3 class="text-xl font-bold mb-4 text-center text-green-400 flex items-center justify-center">
        <i class="fas fa-shield-alt mr-2"></i> Güvenlik Bilgisi
    </h3>

    <p class="text-green-300 text-sm">
        Oluşturulan şifreler daima 16 karakter uzunluğunda ve semboller içerecek şekilde oluşturulur.
        Her şifre büyük harf, küçük harf, rakam ve özel karakterler içerir. Güvenliğiniz için özen gösterilmektedir.
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('passwordForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const masterPassword = document.getElementById('master_password').value;
        const siteName = document.getElementById('site_name').value;

        if (!masterPassword || !siteName) {
            alert('Ana şifre ve site adı gereklidir.');
            return;
        }

        const csrfInput = document.getElementById('csrf');
        const csrfName = csrfInput.name;
        const csrfValue = csrfInput.value;

        document.getElementById('loadingIndicator').classList.remove('hidden');
        document.getElementById('passwordResult').classList.add('hidden');

        const body = `master_password=${encodeURIComponent(masterPassword)}&site_name=${encodeURIComponent(siteName)}&${encodeURIComponent(csrfName)}=${encodeURIComponent(csrfValue)}`;

        fetch('<?= base_url('generate/process') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: body
        })
        .then(response => {
            if (response.status === 401) {
                alert('Oturum süreniz doldu. Lütfen tekrar giriş yapın.');
                window.location.href = '<?= base_url('login') ?>';
                throw new Error('Oturum süresi dolmuş');
            }
            if (!response.ok) {
                throw new Error('Sunucu yanıt vermedi: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            document.getElementById('loadingIndicator').classList.add('hidden');
            document.getElementById('generatedPassword').value = data.password;
            document.getElementById('passwordResult').classList.remove('hidden');
        })
        .catch(error => {
            document.getElementById('loadingIndicator').classList.add('hidden');
            console.error('Hata:', error);
            alert('Şifre oluşturulurken bir hata oluştu: ' + error.message);

            if (error.message.includes('Oturum süresi dolmuş')) {
                window.location.href = '<?= base_url('login') ?>';
            }
        });
    });

    const copyButton = document.getElementById('copyButton');
    if (copyButton) {
        copyButton.addEventListener('click', function() {
            const passwordInput = document.getElementById('generatedPassword');
            passwordInput.select();
            document.execCommand('copy');
            this.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-copy"></i>';
            }, 2000);
        });
    }

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
</script>

<?= view('templates/footer') ?>
