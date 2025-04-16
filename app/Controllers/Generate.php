<?php

namespace App\Controllers;

class Generate extends BaseController
{
    private $envPath;
    
    public function __construct()
    {
        $this->envPath = ROOTPATH . '.env';
    }
    
    public function index()
    {
        // Oturum kontrolü
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        
        return view('generate/index');
    }
    
    public function qrCode()
    {
        // Oturum kontrolü
        if (!session()->get('logged_in')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'error' => 'Oturum süresi dolmuş'
                ])->setStatusCode(401);
            }
            return redirect()->to(base_url('login'));
        }
        
        // Session'dan şifre ve site bilgisini al
        $password = session()->get('generated_password');
        $siteName = session()->get('generated_site');
        
        if (empty($password) || empty($siteName)) {
            return $this->response->setJSON([
                'error' => 'Şifre ve site adı bulunamadı'
            ])->setStatusCode(400);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'password' => $password,
            'site' => $siteName,
            'qrData' => 'Site: ' . $siteName . "\nŞifre: " . $password
        ]);
    }
    
    public function process()
    {
        // Oturum kontrolü
        if (!session()->get('logged_in')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'error' => 'Oturum süresi dolmuş'
                ])->setStatusCode(401);
            }
            return redirect()->to(base_url('login'));
        }
        
        try {
            if ($this->request->getMethod() !== 'POST') {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'error' => 'Sadece POST istekleri kabul edilir'
                    ])->setStatusCode(405);
                }
                return redirect()->to(base_url('generate'));
            }
            
            $masterPassword = $this->request->getPost('master_password');
            $siteName = strtolower($this->request->getPost('site_name'));
            
            // Validasyon
            if (empty($masterPassword) || empty($siteName)) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'error' => 'Ana şifre ve site adı gereklidir'
                    ])->setStatusCode(400);
                }
                session()->setFlashdata('error', 'Ana şifre ve site adı gereklidir.');
                return redirect()->to(base_url('generate'));
            }
            
            // Şifre uzunluğunu .env dosyasından al veya varsayılan kullan
            $passwordLength = getenv('DEFAULT_PASSWORD_LENGTH') ? (int)getenv('DEFAULT_PASSWORD_LENGTH') : 16;
            
            // Şifre oluşturma
            $password = $this->generatePassword(
                $masterPassword, 
                $siteName, 
                $passwordLength
            );
            
            // Şifreyi .env dosyasına kaydet
            $this->savePasswordToEnv($siteName, $password);
            
            // Session'a şifre ve site bilgilerini kaydet
            session()->set('generated_password', $password);
            session()->set('generated_site', $siteName);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'password' => $password,
                    'site' => $siteName
                ]);
            }
            
            session()->setFlashdata('success', 'Şifre başarıyla oluşturuldu ve kaydedildi.');
            return redirect()->to(base_url('generate/display'));
            
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'error' => 'Şifre oluşturulurken bir hata oluştu'
                ])->setStatusCode(500);
            }
            
            session()->setFlashdata('error', 'Şifre oluşturulurken bir hata oluştu.');
            return redirect()->to(base_url('generate'));
        }
    }
    
    /**
     * Şifre oluşturma
     */
    private function generatePassword($masterPassword, $siteName, $length = 16)
    {
        // Karakter havuzları
        $uppercaseChars = 'ABCDEFGHJKLMNPQRSTUVWXYZ'; // I ve O çıkarıldı
        $lowercaseChars = 'abcdefghijkmnopqrstuvwxyz'; // l çıkarıldı
        $numberChars = '23456789'; // 0 ve 1 çıkarıldı
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';
        
        // Karakter havuzunu ayarla
        $characterPool = $uppercaseChars . $lowercaseChars . $numberChars . $specialChars;
        
        // Gelişmiş karma fonksiyonu - PBKDF2 ile güçlendirilmiş
        $iterations = 10000; // PBKDF2 iterasyon sayısı
        $salt = $siteName . 'byapass_v2'; // Tuz değeri
        
        // PBKDF2 ile anahtar türetme
        $derivedKey = hash_pbkdf2(
            'sha256',              // Hash algoritması
            $masterPassword,       // Ana şifre
            $salt,                 // Tuz değeri
            $iterations,           // Yineleme sayısı
            64,                    // Çıktı uzunluğu (bytes)
            true                   // Raw binary output
        );
        
        // Base64 ile kodla
        $base64 = base64_encode($derivedKey);
        
        // Güvenli olmayan karakterleri temizle
        $base64 = str_replace(['=', '+', '/'], '', $base64);
        
        // Hash'ten deterministik şifre üret
        $password = '';
        $hashBytes = unpack('C*', $derivedKey);
        
        // Şifre oluştur
        for ($i = 0; $i < $length; $i++) {
            $index = ($hashBytes[($i % count($hashBytes)) + 1] + $i) % strlen($characterPool);
            $password .= $characterPool[$index];
        }
        
        // Karakter tiplerini zorunlu kıl
        $requiredTypes = [];
        if (!preg_match('/[A-Z]/', $password)) {
            $requiredTypes[] = $uppercaseChars[array_rand(str_split($uppercaseChars))];
        }
        if (!preg_match('/[a-z]/', $password)) {
            $requiredTypes[] = $lowercaseChars[array_rand(str_split($lowercaseChars))];
        }
        if (!preg_match('/[0-9]/', $password)) {
            $requiredTypes[] = $numberChars[array_rand(str_split($numberChars))];
        }
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            $requiredTypes[] = $specialChars[array_rand(str_split($specialChars))];
        }
        
        // Eksik karakter tiplerini ekle
        foreach ($requiredTypes as $index => $char) {
            // Deterministik bir şekilde karakter pozisyonlarını seç
            $position = ($hashBytes[($index * 3) % count($hashBytes) + 1] + $index) % $length;
            $password[$position] = $char;
        }
        
        return $password;
    }
    
    /**
     * Şifreyi .env dosyasına kaydet
     */
    private function savePasswordToEnv($siteName, $password)
    {
        // Site adını güvenli bir anahtar formatına dönüştür
        $key = 'PASSWORD_' . strtoupper(preg_replace('/[^a-zA-Z0-9]/', '_', $siteName));
        
        // .env dosya içeriğini oku
        $envContent = file_get_contents($this->envPath);
        
        // Bu anahtar zaten var mı kontrol et
        if (preg_match("/$key=.*/", $envContent)) {
            // Mevcut değeri güncelle
            $envContent = preg_replace("/$key=.*/", "$key=\"$password\"", $envContent);
        } else {
            // Yeni bir değer ekle
            $envContent .= "\n$key=\"$password\"";
        }
        
        // Dosyaya geri yaz
        file_put_contents($this->envPath, $envContent);
    }
    
    /**
     * Şifre görüntüleme sayfası
     */
    public function display()
    {
        // Oturum kontrolü
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        
        // Session'dan şifre ve site bilgilerini al
        $password = session()->get('generated_password');
        $siteName = session()->get('generated_site');
        
        if (empty($password) || empty($siteName)) {
            session()->setFlashdata('error', 'Şifre bilgisi bulunamadı. Lütfen yeni bir şifre oluşturun.');
            return redirect()->to(base_url('generate'));
        }
        
        // Şifre entropisini hesapla (çeşitlilik ölçümü)
        $entropy = $this->calculatePasswordEntropy($password);
        
        return view('generate/display', [
            'password' => $password,
            'site_name' => $siteName,
            'entropy' => $entropy
        ]);
    }
    
    /**
     * Şifre entropisini hesapla
     */
    private function calculatePasswordEntropy($password)
    {
        $length = strlen($password);
        $hasUppercase = preg_match('/[A-Z]/', $password) ? 26 : 0;
        $hasLowercase = preg_match('/[a-z]/', $password) ? 26 : 0;
        $hasNumbers = preg_match('/[0-9]/', $password) ? 10 : 0;
        $hasSpecial = preg_match('/[^a-zA-Z0-9]/', $password) ? 33 : 0;
        
        $charPool = $hasUppercase + $hasLowercase + $hasNumbers + $hasSpecial;
        $entropy = round($length * log($charPool, 2));
        
        return $entropy;
    }
    
    /**
     * Gelişmiş şifre oluşturma sayfası
     */
    public function advanced()
    {
        // Oturum kontrolü
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        
        return view('generate/advanced');
    }
} 