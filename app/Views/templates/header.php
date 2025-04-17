<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>byaPass - Güvenli Şifre Üretici</title>
    <meta name="description" content="Deterministik şifre üretme aracı. Şifrenizi hiçbir yerde saklamadan, her site için aynı şifreyi yeniden üretebilirsiniz.">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Hacker Tarzı Font -->
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --hacker-green: #0f0;
            --hacker-dark: #0a0a0a;
            --hacker-gray: #222;
            --hacker-border: #1a1a1a;
        }
        
        body {
            background-color: var(--hacker-dark);
            color: var(--hacker-green);
            font-family: 'Share Tech Mono', monospace;
        }
        
        .container {
            max-width: 800px;
        }
        
        .qr-container {
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }
        
        /* Hacker Tarzı UI */
        .hacker-card {
            background-color: var(--hacker-gray);
            border: 1px solid var(--hacker-border);
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.2);
        }
        
        .hacker-input {
            background-color: #111 !important;
            color: var(--hacker-green) !important;
            border-color: var(--hacker-border) !important;
            font-family: 'Share Tech Mono', monospace !important;
        }
        
        .hacker-btn {
            background-color: var(--hacker-dark) !important;
            color: var(--hacker-green) !important;
            border: 1px solid var(--hacker-green) !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        
        .hacker-btn:hover {
            background-color: var(--hacker-green) !important;
            color: var(--hacker-dark) !important;
            box-shadow: 0 0 10px var(--hacker-green);
        }
        
        /* Terminal Görünüm */
        .terminal-header {
            background-color: var(--hacker-dark);
            padding: 8px;
            border-bottom: 1px solid var(--hacker-green);
            display: flex;
            align-items: center;
        }
        
        .terminal-header .circles {
            display: flex;
            margin-right: 10px;
        }
        
        .terminal-header .circle {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 6px;
        }
        
        .terminal-header .circle.red { background-color: #ff5f56; }
        .terminal-header .circle.yellow { background-color: #ffbd2e; }
        .terminal-header .circle.green { background-color: #27c93f; }
        
        .terminal-title {
            font-size: 12px;
            color: #999;
        }
        
        .glitch-effect {
            position: relative;
            color: var(--hacker-green);
            text-shadow: 0 0 5px var(--hacker-green);
        }
        
        .glitch-effect::before, .glitch-effect::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .glitch-effect::before {
            left: 2px;
            text-shadow: -1px 0 red;
            animation: glitch-anim-1 2s infinite linear alternate-reverse;
        }
        
        .glitch-effect::after {
            left: -2px;
            text-shadow: -1px 0 blue;
            animation: glitch-anim-2 3s infinite linear alternate-reverse;
        }
        
        @keyframes glitch-anim-1 {
            0% { clip-path: inset(20% 0 80% 0); }
            20% { clip-path: inset(60% 0 40% 0); }
            40% { clip-path: inset(40% 0 60% 0); }
            60% { clip-path: inset(80% 0 20% 0); }
            80% { clip-path: inset(30% 0 70% 0); }
            100% { clip-path: inset(50% 0 50% 0); }
        }
        
        @keyframes glitch-anim-2 {
            0% { clip-path: inset(30% 0 70% 0); }
            20% { clip-path: inset(70% 0 30% 0); }
            40% { clip-path: inset(10% 0 90% 0); }
            60% { clip-path: inset(90% 0 10% 0); }
            80% { clip-path: inset(20% 0 80% 0); }
            100% { clip-path: inset(60% 0 40% 0); }
        }
        
        /* Mobil Uyumluluk */
        @media (max-width: 640px) {
            .container {
                width: 100%;
                padding: 10px;
            }
            
            .hacker-card {
                padding: 15px !important;
            }
            
            nav ul {
                flex-direction: column;
                align-items: flex-end;
            }
            
            nav ul li {
                margin-top: 8px;
            }
        }
    </style>
    
    <!-- QR Kod Kütüphanesi -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
</head>
<body class="min-h-screen flex flex-col">
    <header class="bg-black text-green-400 py-4 border-b border-green-400">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold glitch-effect" data-text="byaPass">byaPass</h1>
                    <p class="text-sm text-green-400"><i class="fas fa-lock"></i> Güvenli Şifre Üretici</p>
                </div>
                <nav>
                    <ul class="flex space-x-4">
                        <li><a href="<?= base_url('generate') ?>" class="hover:text-green-300"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                        <?php if (session()->get('logged_in')): ?>
                        <li><a href="<?= base_url('login/logout') ?>" class="hover:text-green-300"><i class="fas fa-sign-out-alt"></i> Çıkış</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-grow py-8">
        <div class="container mx-auto px-4">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-900 border border-red-500 text-red-300 px-4 py-3 rounded mb-4">
                    <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-900 border border-green-500 text-green-300 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?> 