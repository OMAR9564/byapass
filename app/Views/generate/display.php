<?= view('templates/header') ?>

<div class="max-w-md mx-auto hacker-card p-6 rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-green-400 glitch-effect" data-text="ŞİFRE GÖRÜNTÜLEME">ŞİFRE GÖRÜNTÜLEME</h2>
    
    <div class="flex justify-center mb-4">
        <div class="inline-block w-16 h-1 bg-green-400"></div>
    </div>
    
    <?php if (session()->getFlashdata('success')): ?>
    <div class="mb-4 p-3 bg-green-900 border border-green-600 rounded-lg text-green-200 text-sm">
        <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
    <?php endif; ?>
    
    <div class="my-6 p-4 bg-gray-900 border border-green-500 rounded-lg">
        <h3 class="text-lg font-bold mb-2 text-green-400 flex items-center">
            <i class="fas fa-globe mr-2"></i> Site: <span class="ml-2 text-white"><?= $site_name ?></span>
        </h3>
        
        <h3 class="text-lg font-bold mb-2 text-green-400 flex items-center">
            <i class="fas fa-key mr-2"></i> Oluşturulan Şifre:
        </h3>
        <div class="flex mb-3">
            <input type="text" id="generatedPassword" value="<?= $password ?>" 
                  class="hacker-input shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline bg-black"
                  readonly>
            <button id="copyButton" class="hacker-btn py-2 px-4 rounded ml-2" onclick="copyPassword()">
                <i class="fas fa-copy"></i>
            </button>
        </div>
        
        <div class="mt-3">
            <div class="flex items-center space-x-2">
                <span class="text-xs text-green-500">Şifre Gücü:</span>
                <div class="flex-1 bg-gray-800 h-2 rounded-full overflow-hidden">
                    <?php 
                        $strengthPercentage = min(100, ($entropy / 120) * 100);
                        $strengthClass = 'bg-red-500';
                        $strengthText = 'Zayıf';
                        
                        if ($entropy >= 70) {
                            $strengthClass = 'bg-green-500';
                            $strengthText = 'Çok Güçlü';
                        } else if ($entropy >= 50) {
                            $strengthClass = 'bg-green-400';
                            $strengthText = 'Güçlü';
                        } else if ($entropy >= 30) {
                            $strengthClass = 'bg-yellow-500';
                            $strengthText = 'Orta';
                        }
                    ?>
                    <div class="<?= $strengthClass ?> h-full" style="width: <?= $strengthPercentage ?>%"></div>
                </div>
                <span class="text-xs text-green-400"><?= $strengthText ?> (<?= $entropy ?> bit)</span>
            </div>
        </div>
        
        <div class="mt-4">
            <button id="showQRButton" class="hacker-btn py-2 px-4 rounded w-full flex items-center justify-center">
                <i class="fas fa-qrcode mr-2"></i> QR KOD GÖSTER
            </button>
        </div>
        <div id="qrCode" class="qr-container mt-4 hidden bg-white p-2 rounded"></div>
        
        <p class="text-xs text-green-600 mt-4 flex items-center">
            <i class="fas fa-exclamation-triangle mr-1"></i> Şifreyi kaydedin veya kopyalayın. Güvenlik nedeniyle bu sayfa tekrar yüklendiğinde şifreyi göremeyebilirsiniz.
        </p>
    </div>
    
    <div class="flex items-center justify-center mt-6">
        <a href="<?= base_url('generate') ?>" class="hacker-btn py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            <i class="fas fa-arrow-left mr-2"></i> ANA SAYFAYA DÖN
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Şifre kopyalama fonksiyonu
    window.copyPassword = function() {
        const passwordInput = document.getElementById('generatedPassword');
        passwordInput.select();
        document.execCommand('copy');
        
        // Kopyalandı bilgisini göster
        const copyButton = document.getElementById('copyButton');
        copyButton.innerHTML = '<i class="fas fa-check"></i>';
        
        // 2 saniye sonra ikonu eski haline getir
        setTimeout(() => {
            copyButton.innerHTML = '<i class="fas fa-copy"></i>';
        }, 2000);
    };
    
    // QR kod gösterme/gizleme
    const showQRButton = document.getElementById('showQRButton');
    const qrCodeContainer = document.getElementById('qrCode');
    
    if (showQRButton && qrCodeContainer) {
        showQRButton.addEventListener('click', function() {
            if (qrCodeContainer.classList.contains('hidden')) {
                // QR kodu göster
                qrCodeContainer.classList.remove('hidden');
                showQRButton.innerHTML = '<i class="fas fa-eye-slash mr-2"></i> QR KODU GİZLE';
                
                // QR kod verisi al
                fetch('<?= base_url('generate/qr-code') ?>')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // QR kod oluştur
                            const qrcode = new QRCode(qrCodeContainer, {
                                text: JSON.stringify({
                                    site: data.site,
                                    password: data.password
                                }),
                                width: 200,
                                height: 200,
                                colorDark: "#00FF00",
                                colorLight: "#FFFFFF",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                        } else {
                            qrCodeContainer.innerHTML = '<div class="text-red-500 p-2">' + data.error + '</div>';
                        }
                    })
                    .catch(error => {
                        qrCodeContainer.innerHTML = '<div class="text-red-500 p-2">QR kod oluşturulurken bir hata oluştu.</div>';
                        console.error('QR code error:', error);
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