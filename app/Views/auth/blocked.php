<?= view('templates/header') ?>

<div class="max-w-md mx-auto hacker-card p-6 rounded-lg">
    <div class="text-center mb-6">
        <i class="fas fa-ban text-4xl text-red-400 mb-2"></i>
        <h2 class="text-2xl font-bold mb-2 text-red-400 glitch-effect" data-text="ERİŞİM ENGELLENDİ">ERİŞİM ENGELLENDİ</h2>
        <div class="flex justify-center">
            <div class="inline-block w-16 h-1 bg-red-400 mb-4"></div>
        </div>
        <p class="text-red-300 text-sm">
            <i class="fas fa-exclamation-triangle mr-1"></i> Uygulama şu anda kullanıma kapalıdır. Bakım çalışması devam etmektedir.
        </p>
    </div>
    
    <div class="terminal-input-container p-4 bg-black rounded border border-red-800 mt-6">
        <div class="text-red-500 text-sm mb-1">// HATA KODU: 403 //</div>
        <div class="text-gray-400 text-xs mb-3">
            $ ./system_status.sh<br>
            <span class="text-red-400">STOPPED</span>: Sistem bakım modunda<br>
            <span class="text-yellow-400">WAITING</span>: Yönetici onayı bekliyor<br>
            <span class="text-red-400">ERROR</span>: Erişim yetkisi reddedildi<br>
        </div>
        <div class="text-green-400 text-xs">
            <div>> Sistem bakım modunda.</div>
            <div>> Lütfen daha sonra tekrar deneyin.</div>
            <div class="blink">> _</div>
        </div>
    </div>
    
    <div class="text-center mt-6">
        <a href="<?= base_url('/') ?>" class="hacker-btn py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-block">
            <i class="fas fa-home mr-2"></i> Ana Sayfaya Dön
        </a>
    </div>
</div>

<style>
    .blink {
        animation: blink-animation 1s steps(2, start) infinite;
    }
    @keyframes blink-animation {
        to {
            visibility: hidden;
        }
    }
</style>

<?= view('templates/footer') ?> 