<?= view('templates/header') ?>

<div class="max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-green-400 glitch-effect" data-text="GELİŞMİŞ ÜRETEÇ">GELİŞMİŞ ÜRETEÇ</h2>
    
    <div class="flex justify-center mb-4">
        <div class="inline-block w-16 h-1 bg-green-400"></div>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
    <div class="mb-4 p-3 bg-green-900 border border-green-600 rounded-lg text-green-200 text-sm">
        <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
    <?php endif; ?>
    
    <p class="mb-6 text-green-300 text-sm">
        <i class="fas fa-shield-alt mr-1"></i> Gelişmiş şifre oluşturma seçenekleri. 
        Bu sayfada daha fazla şifre oluşturma seçeneği bulabilirsiniz.
    </p>
    
    <form id="advancedPasswordForm" class="space-y-4">
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
        
        <div class="terminal-input-container">
            <label for="length" class="flex items-center text-green-400 text-sm font-bold mb-2">
                <i class="fas fa-text-width mr-2"></i> ŞİFRE UZUNLUĞU: <span id="lengthValue" class="text-green-300">16</span>
            </label>
            <input type="range" name="length" id="length" min="4" max="64" value="16" 
                  class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
            <div class="flex justify-between">
                <span class="text-xs text-green-500">4</span>
                <span class="text-xs text-green-500">64</span>
            </div>
        </div>
        
        <div class="terminal-input-container">
            <h3 class="flex items-center text-green-400 text-sm font-bold mb-2">
                <i class="fas fa-font mr-2"></i> KARAKTER TİPLERİ
            </h3>
            <div class="grid grid-cols-2 gap-2 text-green-300">
                <label class="flex items-center p-2 rounded border border-green-900 hover:border-green-500 transition-colors">
                    <input type="checkbox" name="include_uppercase" checked class="mr-2 hacker-checkbox appearance-none h-4 w-4 border border-green-400 rounded bg-black checked:bg-green-500 checked:border-transparent focus:outline-none">
                    <span class="text-sm"><i class="fas fa-font mr-1"></i> Büyük Harfler (A-Z)</span>
                </label>
                <label class="flex items-center p-2 rounded border border-green-900 hover:border-green-500 transition-colors">
                    <input type="checkbox" name="include_lowercase" checked class="mr-2 hacker-checkbox appearance-none h-4 w-4 border border-green-400 rounded bg-black checked:bg-green-500 checked:border-transparent focus:outline-none">
                    <span class="text-sm"><i class="fas fa-font mr-1"></i> Küçük Harfler (a-z)</span>
                </label>
                <label class="flex items-center p-2 rounded border border-green-900 hover:border-green-500 transition-colors">
                    <input type="checkbox" name="include_numbers" checked class="mr-2 hacker-checkbox appearance-none h-4 w-4 border border-green-400 rounded bg-black checked:bg-green-500 checked:border-transparent focus:outline-none">
                    <span class="text-sm"><i class="fas fa-hashtag mr-1"></i> Rakamlar (0-9)</span>
                </label>
                <label class="flex items-center p-2 rounded border border-green-900 hover:border-green-500 transition-colors">
                    <input type="checkbox" name="include_special" class="mr-2 hacker-checkbox appearance-none h-4 w-4 border border-green-400 rounded bg-black checked:bg-green-500 checked:border-transparent focus:outline-none">
                    <span class="text-sm"><i class="fas fa-asterisk mr-1"></i> Özel Karakter (!@#$)</span>
                </label>
            </div>
        </div>
        
        <div class="terminal-input-container">
            <label for="strength_profile" class="flex items-center text-green-400 text-sm font-bold mb-2">
                <i class="fas fa-shield-alt mr-2"></i> GÜÇLÜ ÖNERİ MODU
            </label>
            <select name="strength_profile" id="strength_profile" 
                   class="hacker-input shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline focus:border-green-400">
                <option value="balanced">Dengeli (Varsayılan)</option>
                <option value="high_security">Yüksek Güvenlik (Tüm karakter tipleri)</option>
                <option value="easy_to_read">Kolay Okunabilir (Benzer karakterler çıkarılır)</option>
            </select>
        </div>
        
        <div class="flex items-center justify-center mt-2">
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
        
        <div class="mt-3">
            <div class="flex items-center space-x-2">
                <span class="text-xs text-green-500">Şifre Gücü:</span>
                <div class="flex-1 bg-gray-800 h-2 rounded-full overflow-hidden">
                    <div id="entropyBar" class="bg-green-500 h-full" style="width: 0%"></div>
                </div>
                <span id="entropyText" class="text-xs text-green-400">Hesaplanıyor...</span>
            </div>
        </div>
        
        <div class="mt-4">
            <button id="showQRButton" class="hacker-btn py-2 px-4 rounded w-full flex items-center justify-center">
                <i class="fas fa-qrcode mr-2"></i> QR KOD GÖSTER
            </button>
        </div>
        <div id="qrCode" class="qr-container mt-4 hidden bg-white p-2 rounded"></div>
        
        <p class="text-xs text-green-600 mt-2 flex items-center">
            <i class="fas fa-exclamation-triangle mr-1"></i> Sayfayı yenilediğinizde şifre kaybolacaktır!
        </p>
    </div>
</div>

<div class="mt-8 max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h3 class="text-xl font-bold mb-4 text-center text-green-400 flex items-center justify-center">
        <i class="fas fa-code mr-2"></i> ALGORİTMA AÇIKLAMASI
    </h3>
    
    <div class="bg-black p-4 rounded-lg mb-4 font-mono text-sm text-green-400">
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> INPUT: master_password, site_name</p>
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> SALT: site_name + "byapass_v2"</p>
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> PBKDF2: 10,000 iterasyon (SHA-256)</p>
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> DERIVE: 64-byte anahtar oluştur</p>
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> SELECT: Doğru karakter havuzunu belirle</p>
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> BUILD: Karakter havuzundan deterministik şifre</p>
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> ENFORCE: Seçili karakter tiplerini zorunlu kıl</p>
        <p class="flex items-center"><i class="fas fa-arrow-right mr-2"></i> OUTPUT: Belirtilen uzunlukta güçlü şifre</p>
    </div>
    
    <p class="text-green-300 text-sm">
        Bu algoritma, PBKDF2 gibi modern kriptografik teknikleri kullanarak, aynı girdilerle her zaman aynı şifreyi üretir. 
        Bu şekilde şifrelerinizi hatırlamanıza gerek kalmaz, sadece bu sayfayı kullanarak aynı girdilerle her zaman aynı şifreye erişebilirsiniz.
    </p>
</div>

<div class="mt-8 max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h3 class="text-xl font-bold mb-4 text-center text-green-400 flex items-center justify-center">
        <i class="fas fa-mobile-alt mr-2"></i> OFFLINE KULLANIM (PWA)
    </h3>
    
    <p class="text-green-300 mb-4 text-sm">
        byaPass'i internet bağlantısı olmadan da kullanabilirsiniz. Chrome, Edge veya diğer modern tarayıcılarda 
        adres çubuğunun yanındaki "Yükle" veya "+" simgesine tıklayarak uygulamayı cihazınıza yükleyebilirsiniz.
    </p>
    
    <div class="text-center">
        <i class="fas fa-download text-4xl text-green-400"></i>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Şifre uzunluğu değerini göster
    const lengthInput = document.getElementById('length');
    const lengthValue = document.getElementById('lengthValue');
    
    lengthInput.addEventListener('input', function() {
        lengthValue.textContent = this.value;
    });
    
    // Güçlü öneri modu seçildiğinde karakter tiplerini güncelle
    const strengthProfile = document.getElementById('strength_profile');
    const includeUppercase = document.querySelector('input[name="include_uppercase"]');
    const includeLowercase = document.querySelector('input[name="include_lowercase"]');
    const includeNumbers = document.querySelector('input[name="include_numbers"]');
    const includeSpecial = document.querySelector('input[name="include_special"]');
    
    strengthProfile.addEventListener('change', function() {
        if (this.value === 'high_security') {
            includeUppercase.checked = true;
            includeLowercase.checked = true;
            includeNumbers.checked = true;
            includeSpecial.checked = true;
        } else if (this.value === 'easy_to_read') {
            includeUppercase.checked = true;
            includeLowercase.checked = true;
            includeNumbers.checked = true;
            includeSpecial.checked = false;
        }
    });
    
    // Şifre kopyalama butonu
    const copyButton = document.getElementById('copyButton');
    if (copyButton) {
        copyButton.addEventListener('click', function() {
            const passwordInput = document.getElementById('generatedPassword');
            passwordInput.select();
            document.execCommand('copy');
            
            // Kopyalandı bilgisini göster
            this.innerHTML = '<i class="fas fa-check"></i>';
            
            // 2 saniye sonra ikonu eski haline getir
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-copy"></i>';
            }, 2000);
        });
    }
    
    // QR Kod gösterme
    const showQRButton = document.getElementById('showQRButton');
    const qrCodeDiv = document.getElementById('qrCode');
    
    if (showQRButton && qrCodeDiv) {
        showQRButton.addEventListener('click', function() {
            const password = document.getElementById('generatedPassword').value;
            const siteName = '<?= session()->get('site_name') ?>';
            
            if (qrCodeDiv.classList.contains('hidden')) {
                qrCodeDiv.classList.remove('hidden');
                
                // QR Kod oluştur
                qrCodeDiv.innerHTML = '';
                new QRCode(qrCodeDiv, {
                    text: 'site:' + siteName + ',password:' + password,
                    width: 200,
                    height: 200,
                    colorDark: "#00ff00",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
                
                this.innerHTML = '<i class="fas fa-eye-slash mr-2"></i> QR KODU GİZLE';
            } else {
                qrCodeDiv.classList.add('hidden');
                this.innerHTML = '<i class="fas fa-qrcode mr-2"></i> QR KOD GÖSTER';
            }
        });
    }
    
    // Terminal Input Efektleri
    const inputs = document.querySelectorAll('.hacker-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('border-green-400');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('border-green-400');
        });
    });
    
    // Form submit işleyicisi
    const form = document.getElementById('advancedPasswordForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const params = new URLSearchParams();
        
        for (const [key, value] of formData.entries()) {
            params.append(key, value);
        }
        
        // Yükleme göstergesini göster
        document.getElementById('loadingIndicator').classList.remove('hidden');
        document.getElementById('passwordResult').classList.add('hidden');
        
        // API isteği gönder
        fetch('<?= base_url('generate/process') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Sunucu yanıt vermedi: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            
            // Yükleme göstergesini gizle
            document.getElementById('loadingIndicator').classList.add('hidden');
            
            // Şifreyi göster
            document.getElementById('generatedPassword').value = data.password;
            document.getElementById('passwordResult').classList.remove('hidden');
            
            // Şifre gücünü hesapla
            calculateEntropy(data.password);
            
            // Site bilgisini sakla (QR kod için)
            window.siteName = data.site;
        })
        .catch(error => {
            // Yükleme göstergesini gizle
            document.getElementById('loadingIndicator').classList.add('hidden');
            
            console.error('Hata:', error);
            alert('Şifre oluşturulurken bir hata oluştu: ' + error.message);
        });
    });
    
    // Şifre entropisini hesapla (basit bir yaklaşım)
    function calculateEntropy(password) {
        let poolSize = 0;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[^A-Za-z0-9]/.test(password);
        
        if (hasUpper) poolSize += 26;
        if (hasLower) poolSize += 26;
        if (hasNumber) poolSize += 10;
        if (hasSpecial) poolSize += 32;
        
        const entropy = Math.log(poolSize) / Math.log(2) * password.length;
        const entropyRounded = Math.round(entropy * 10) / 10;
        
        // Entropi görselini güncelle
        const strengthPercentage = Math.min(100, (entropyRounded / 120) * 100);
        let strengthText = 'Zayıf';
        
        if (entropyRounded >= 70) {
            strengthText = 'Çok Güçlü';
            document.getElementById('entropyBar').className = 'bg-green-500 h-full';
        } else if (entropyRounded >= 50) {
            strengthText = 'Güçlü';
            document.getElementById('entropyBar').className = 'bg-green-400 h-full';
        } else if (entropyRounded >= 30) {
            strengthText = 'Orta';
            document.getElementById('entropyBar').className = 'bg-yellow-500 h-full';
        } else {
            document.getElementById('entropyBar').className = 'bg-red-500 h-full';
        }
        
        document.getElementById('entropyBar').style.width = strengthPercentage + '%';
        document.getElementById('entropyText').textContent = strengthText + ' (' + entropyRounded + ' bit)';
    }
    
    // QR kod gösterme/gizleme
    const showQRButton = document.getElementById('showQRButton');
    const qrCodeContainer = document.getElementById('qrCode');
    
    if (showQRButton && qrCodeContainer) {
        showQRButton.addEventListener('click', function() {
            if (qrCodeContainer.classList.contains('hidden')) {
                // QR kodu göster
                qrCodeContainer.classList.remove('hidden');
                showQRButton.innerHTML = '<i class="fas fa-eye-slash mr-2"></i> QR KODU GİZLE';
                
                const password = document.getElementById('generatedPassword').value;
                const siteName = window.siteName || 'unknown';
                
                // QR kod içeriğini oluştur
                qrCodeContainer.innerHTML = '';
                new QRCode(qrCodeContainer, {
                    text: JSON.stringify({
                        site: siteName,
                        password: password
                    }),
                    width: 200,
                    height: 200,
                    colorDark: "#00FF00",
                    colorLight: "#FFFFFF",
                    correctLevel: QRCode.CorrectLevel.H
                });
            } else {
                // QR kodu gizle
                qrCodeContainer.classList.add('hidden');
                qrCodeContainer.innerHTML = '';
                showQRButton.innerHTML = '<i class="fas fa-qrcode mr-2"></i> QR KOD GÖSTER';
            }
        });
    }
});
</script>

<?= view('templates/footer') ?> 