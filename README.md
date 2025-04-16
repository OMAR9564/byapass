# byaPass - Güvenli Şifre Üretici

byaPass, hiçbir yerde saklanmayan, deterministik olarak üretilen güvenli şifreler oluşturmanızı sağlayan bir araçtır.

## Özellikler

- Ana şifre ve site adı kullanarak benzersiz, güçlü şifreler oluşturur
- Şifreleri hiçbir yerde saklamaz veya kaydetmez
- Aynı girdilerle her zaman aynı şifreyi üretir
- Basit ve kullanımı kolay arayüz
- SHA-256 ve Base64 tabanlı güçlü şifreleme algoritması
- Özel karakter, büyük/küçük harf ve rakam özelleştirmesi
- QR kod ile mobil tarayıcıya aktarım
- Progressive Web App (PWA) desteği ile offline kullanım
- Güçlü öneri modları (Dengeli, Yüksek Güvenlik, Kolay Okunabilir)

## Kurulum

1. Repoyu klonlayın:
```
git clone https://github.com/kullanici/byapass.git
cd byapass
```

2. Composer bağımlılıklarını yükleyin:
```
composer install
```

3. `.env` dosyasını düzenleyin:
   - Admin şifresini değiştirin (`ADMIN_PASSWORD`)
   - Gerekirse baseURL'i yapılandırın

4. Geliştirme sunucusunu başlatın:
```
php spark serve
```

5. `http://localhost:8080` adresini tarayıcınızda açın.

## Offline Kullanım (PWA)

byaPass, Progressive Web App (PWA) olarak kurulabilir, böylece internet bağlantısı olmadığında bile kullanabilirsiniz:

1. Chrome, Edge veya diğer modern tarayıcılarda byaPass'i açın
2. Adres çubuğunun yanındaki "Yükle" veya "+" simgesine tıklayın
3. Uygulama masaüstünüze veya mobil cihazınıza kurulacaktır

## QR Kod İle Aktarım

Oluşturulan şifreleri QR kod aracılığıyla başka cihazlara aktarabilirsiniz:

1. Şifre oluşturduktan sonra "QR Kod Göster" butonuna tıklayın
2. Oluşturulan QR kodu mobil cihazınızla tarayın
3. Site adı ve şifre otomatik olarak aktarılacaktır

## Gelişmiş Özellikler

Gelişmiş sayfada aşağıdaki özelleştirmeleri yapabilirsiniz:

- Şifre uzunluğunu (4-64 karakter) ayarlama
- Karakter tiplerini (büyük/küçük harf, rakam, özel karakter) seçme
- Güçlü öneri modları:
  - Dengeli: Varsayılan mod
  - Yüksek Güvenlik: Tüm karakter tiplerini içerir
  - Kolay Okunabilir: Karıştırılabilecek karakterleri çıkarır (0/O, 1/l gibi)

## Güvenlik

- Şifreler tamamen istemci tarafında oluşturulur
- Hiçbir şifre veritabanında veya sunucuda saklanmaz
- Aynı girdilerle her zaman aynı şifre oluşturulur, bu sayede şifrelerinizi hatırlamanıza gerek kalmaz

## Katkıda Bulunma

1. Bu repoyu fork edin
2. Yeni bir branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişikliklerinizi commit edin (`git commit -m 'feat: Add some amazing feature'`)
4. Branch'inize push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Daha fazla bilgi için `LICENSE` dosyasına bakın.