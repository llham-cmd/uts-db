<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --hijau-gelap: #0d4722;
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

        .kartu-bantuan {
            background-color: var(--hijau-gelap);
            color: var(--krem);
            padding: 40px 30px;
            border: 2px solid var(--emas);
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 90%;
            position: relative;
        }

        .kartu-bantuan::before, .kartu-bantuan::after {
            content: ""; position: absolute; width: 40px; height: 40px; border: 2px solid var(--emas);
        }
        .kartu-bantuan::before { top: 10px; left: 10px; border-right: none; border-bottom: none; border-radius: 10px 0 0 0; }
        .kartu-bantuan::after { bottom: 10px; right: 10px; border-left: none; border-top: none; border-radius: 0 0 10px 0; }

        h1 { color: var(--krem); font-size: 22px; line-height: 1.5; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid rgba(212, 175, 55, 0.4); }
        h2 { font-size: 20px; margin: 15px 0; font-weight: normal; }
        .label { color: var(--emas); font-weight: bold; display: inline-block; width: 80px; text-align: left; }
        
        .nomor-hp {
            display: inline-block; background-color: var(--emas); color: var(--hijau-gelap);
            padding: 8px 25px; border-radius: 30px; font-weight: bold; font-size: 22px;
            margin-top: 15px; letter-spacing: 2px; box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
        }
    </style>
</head>
<body>

    <nav>
        <a href="/profil">Profil</a>
        <a href="/katalog">katalog</a>
        <a href="/bantuan" class="aktif">Bantuan</a>
    </nav>

    <div class="kartu-bantuan">
        <h1>Hubungi Nomor Ini Jika Anda Memerlukan Bantuan</h1>
        <h2><span class="label">Nama</span> : Edho Bima Putra</h2>
        <h2><span class="label">No HP</span> : <br><span class="nomor-hp">085156669435</span></h2>
    </div>

</body>
</html>