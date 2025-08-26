<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cara Mendapatkan Chat ID Telegram</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .instruction-card {
            border: 2px solid #0088cc;
            border-radius: 15px;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        }

        .step-number {
            background: #0088cc;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .code-box {
            background: #f8f9fa;
            border: 2px dashed #6c757d;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: bold;
            color: #0088cc;
        }

        .bot-link {
            background: #0088cc;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .bot-link:hover {
            background: #006699;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="instruction-card p-4 mb-4">
                    <div class="text-center mb-4">
                        <h1 class="text-primary mb-3">
                            <i class="fas fa-robot"></i> Cara Mendapatkan Chat ID Telegram
                        </h1>
                        <p class="lead">Ikuti langkah-langkah di bawah ini untuk mendapatkan Chat ID Anda</p>
                    </div>

                    <!-- Step 1 -->
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <div class="step-number">1</div>
                        </div>
                        <div class="col">
                            <h4>Buka Bot Telegram</h4>
                            <p class="mb-2">Klik link di bawah ini atau cari manual di Telegram:</p>
                            <div class="text-center">
                                <a href="https://t.me/<?= $botUsername ?>"
                                    class="bot-link"
                                    target="_blank">
                                    📱 Buka @<?= $botUsername ?>
                                </a>
                            </div>
                            <small class="text-muted">Atau cari manual: <strong>@<?= $botUsername ?></strong></small>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <div class="step-number">2</div>
                        </div>
                        <div class="col">
                            <h4>Tekan Tombol START</h4>
                            <p>Di dalam chat bot, tekan tombol <strong>"START"</strong> atau ketik:</p>
                            <div class="code-box p-3 text-center">
                                /start
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <div class="step-number">3</div>
                        </div>
                        <div class="col">
                            <h4>Salin Chat ID Anda</h4>
                            <p>Bot akan membalas dengan pesan yang berisi <strong>Chat ID</strong> Anda.</p>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Chat ID</strong> berupa angka panjang, contoh: <code>123456789</code>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <div class="step-number">4</div>
                        </div>
                        <div class="col">
                            <h4>Berikan ke Admin/Guru</h4>
                            <p>Salin Chat ID tersebut dan berikan kepada admin sekolah atau guru Anda untuk didaftarkan dalam sistem.</p>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                Setelah terdaftar, Anda akan otomatis menerima pengumuman sekolah!
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Troubleshooting -->
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle"></i>
                            Troubleshooting
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6>Jika bot tidak merespon:</h6>
                        <ul>
                            <li>Pastikan Anda sudah menekan tombol <strong>START</strong></li>
                            <li>Coba ketik <code>/start</code> secara manual</li>
                            <li>Pastikan koneksi internet Anda stabil</li>
                            <li>Tunggu beberapa detik untuk respon bot</li>
                        </ul>

                        <h6 class="mt-3">Jika masih bermasalah:</h6>
                        <ul>
                            <li>Hubungi admin sekolah</li>
                            <li>Atau tanyakan ke guru Anda</li>
                        </ul>
                    </div>
                </div>

                <!-- Bot Info -->
                <div class="text-center mt-4">
                    <small class="text-muted">
                        Bot: <strong><?= $botName ?></strong> (@<?= $botUsername ?>)
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>