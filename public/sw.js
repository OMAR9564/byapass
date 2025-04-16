const CACHE_NAME = 'byapass-v2';
const urlsToCache = [
   '/',
   '/generate',
   '/generate/display',
   '/generate/qr-code',
   '/login',
   '/login/logout',
   '/manifest.json',
   '/icons/byapass_logo.png',
   'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css',
   'https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap',
   'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
   'https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js'
];

// Service Worker kurulumu
self.addEventListener('install', (event) => {
   event.waitUntil(
      caches.open(CACHE_NAME)
         .then((cache) => {
            console.log('Önbellek açıldı');
            return cache.addAll(urlsToCache);
         })
   );
});

// Ağ isteklerini yakala
self.addEventListener('fetch', (event) => {
   event.respondWith(
      caches.match(event.request)
         .then((response) => {
            // Önbellekte bulunduysa, önbellekten yanıt ver
            if (response) {
               return response;
            }

            // Önbellekte yoksa ağ isteği yap
            return fetch(event.request)
               .then((response) => {
                  // Sadece geçerli yanıtları önbelleğe al
                  if (!response || response.status !== 200 || response.type !== 'basic') {
                     return response;
                  }

                  // Yanıtı klonla (yanıt stream olduğu için)
                  const responseToCache = response.clone();

                  caches.open(CACHE_NAME)
                     .then((cache) => {
                        cache.put(event.request, responseToCache);
                     });

                  return response;
               });
         })
   );
}); 