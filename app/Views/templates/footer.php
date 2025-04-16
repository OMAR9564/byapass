        </div>
    </main>

    <footer class="bg-black text-green-400 py-4 mt-auto border-t border-green-500">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm flex items-center"><i class="fas fa-shield-alt mr-2"></i> &copy; 2023 byaPass</p>
                </div>
                <div class="text-sm">
                    <p class="flex items-center"><i class="fas fa-user-secret mr-2"></i> Hiçbir şifreniz saklanmaz</p>
                </div>
            </div>
            <div class="mt-2 text-center text-xs text-green-600">
                <div class="typewriter-text" id="hackerText">
                    Oturum süresi: 956400 saniye | Güvenli bağlantı sağlandı | Veriler şifrelendi | Terminal hazır
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Hacker Efektleri -->
    <script>
        // Yazı Efekti
        document.addEventListener('DOMContentLoaded', function() {
            const text = document.getElementById('hackerText');
            if(text) {
                let content = text.textContent;
                text.textContent = '';
                let i = 0;
                
                function typeWriter() {
                    if (i < content.length) {
                        text.textContent += content.charAt(i);
                        i++;
                        setTimeout(typeWriter, Math.random() * 100 + 30);
                    }
                }
                
                typeWriter();
            }
            
            // Terminal kutuları için eklemeler
            const cards = document.querySelectorAll('.hacker-card');
            cards.forEach(card => {
                const header = document.createElement('div');
                header.className = 'terminal-header';
                header.innerHTML = `
                    <div class="circles">
                        <div class="circle red"></div>
                        <div class="circle yellow"></div>
                        <div class="circle green"></div>
                    </div>
                    <div class="terminal-title">byaPass@${Math.floor(Math.random() * 9000) + 1000}</div>
                `;
                
                card.insertBefore(header, card.firstChild);
            });
        });
    </script>
    
    <!-- PWA Service Worker Kaydı -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?= base_url('sw.js') ?>')
                    .then(registration => {
                        console.log('ServiceWorker başarıyla kaydedildi:', registration.scope);
                    })
                    .catch(error => {
                        console.log('ServiceWorker kaydı başarısız:', error);
                    });
            });
        }
    </script>
</body>
</html> 