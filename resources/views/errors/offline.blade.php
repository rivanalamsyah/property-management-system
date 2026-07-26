<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi Terputus - Kosan</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #09090b;
            color: #f4f4f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            text-align: center;
            max-width: 420px;
            background: #18181b;
            border: 1px solid #27272a;
            padding: 40px 30px;
            border-radius: 24px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }
        .icon {
            width: 64px;
            height: 64px;
            background-color: rgba(79, 70, 229, 0.1);
            color: #6366f1;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: #ffffff;
        }
        p {
            font-size: 14px;
            color: #a1a1aa;
            margin: 0 0 24px 0;
            line-height: 1.6;
        }
        .btn {
            background-color: #4f46e5;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            width: 100%;
        }
        .btn:hover {
            background-color: #4338ca;
        }
        .btn:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 1l22 22M16.72 11.06A10.94 10.94 0 0 1 19 12.5M5 11.5a10.94 10.94 0 0 1 5.83-2.84M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"></path>
            </svg>
        </div>
        <h1>Koneksi Internet Terputus</h1>
        <p>Perangkat Anda sedang tidak terhubung ke jaringan internet. Silakan periksa koneksi internet atau Wi-Fi Anda lalu coba kembali.</p>
        <button class="btn" onclick="window.location.reload()">Coba Hubungkan Kembali</button>
    </div>
</body>
</html>
