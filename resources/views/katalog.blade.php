<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --hijau-gelap: #0d4722;
            --hijau-terang: #166534;
            --emas: #d4af37;
            --krem: #fdfbf7;
        }

        /* --- STYLING NAVIGASI --- */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: var(--hijau-gelap);
            padding: 15px 0;
            text-align: center;
            border-bottom: 2px solid var(--emas);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        nav a {
            color: var(--krem);
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: 0.3s;
        }

        nav a:hover, nav a.aktif {
            background-color: var(--emas);
            color: var(--hijau-gelap);
        }

        /* --- STYLING HALAMAN --- */
        body {
            background-color: #f0f4f3;
            background-image: radial-gradient(var(--emas) 1px, transparent 1px);
            background-size: 25px 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Amiri', serif;
            padding-top: 60px;
        }

        .kartu-produk {
            background-color: var(--krem);
            padding: 40px;
            border: 2px solid var(--emas);
            border-radius: 15px 15px 40px 40px; 
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 90%;
            position: relative;
        }

        .kartu-produk::before {
            content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 12px;
            background-color: var(--hijau-gelap); border-radius: 12px 12px 0 0;
        }

        h1 { color: var(--hijau-gelap); font-size: 28px; text-align: center; border-bottom: 2px dashed var(--emas); padding-bottom: 15px; margin-top: 10px; margin-bottom: 30px; }
        .daftar-produk { display: flex; flex-direction: column; gap: 15px; }
        
        h2 {
            background-color: var(--hijau-gelap); color: var(--krem); font-size: 20px;
            margin: 0; padding: 12px 20px; border-radius: 8px; border-left: 6px solid var(--emas);
            display: flex; align-items: center; transition: transform 0.3s ease, background-color 0.3s ease; cursor: pointer;
        }
        h2:hover { transform: translateX(10px); background-color: var(--hijau-terang); }
        .angka { color: var(--emas); font-weight: bold; font-size: 24px; margin-right: 15px; }
    </style>
</head>
<body>

    <nav>
        <a href="/profil">Profil</a>
        <a href="/katalog" class="aktif">katalog</a>
        <a href="/bantuan">Bantuan</a>
    </nav>

    <div class="kartu-produk">
        <h1>Produk Yang Saya Jual</h1>
        <div class="daftar-produk">
            <h2><span class="angka">1.</span> Korban</h2>
            <h2><span class="angka">2.</span> Sholat Ied</h2>
            <h2><span class="angka">3.</span> Berdoa Bersama</h2>
        </div>
    </div>

</body>
</html>