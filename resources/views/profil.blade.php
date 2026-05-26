<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Edho Bima Putra</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --hijau-gelap: #0d4722;
            --emas: #d4af37;
            --krem: #fdfbf7;
        }

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

        body {
            background-color: #f0f4f3;
            background-image: radial-gradient(#d4af37 1px, transparent 1px);
            background-size: 25px 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Amiri', serif;
            padding-top: 60px; 
        }

        .kartu-profil {
            background-color: var(--hijau-gelap);
            color: var(--krem);
            padding: 50px 40px 40px 40px;
            border: 2px solid var(--emas);
            border-radius: 180px 180px 15px 15px;
            text-align: center;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 90%;
            position: relative;
        }

        .kartu-profil::before {
            content: "";
            position: absolute;
            top: 12px; left: 12px; right: 12px; bottom: 12px;
            border: 1px dashed var(--emas);
            border-radius: 170px 170px 10px 10px;
            pointer-events: none;
        }

        h1 { color: var(--emas); font-size: 26px; border-bottom: 2px solid var(--emas); padding-bottom: 15px; margin-bottom: 30px; position: relative; z-index: 1; }
        h2 { font-size: 22px; margin: 15px 0; font-weight: normal; letter-spacing: 0.5px; position: relative; z-index: 1; }
        .label { color: var(--emas); font-weight: bold; margin-right: 5px; }
    </style>
</head>
<body>

    <nav>
        <a href="/profil" class="aktif">Profil</a>
        <a href="/katalog">katalog</a>
        <a href="/bantuan">Bantuan</a>
    </nav>

    <div class="kartu-profil">
        <h1>Ini Merupakan Profil Saya</h1>
        <h2><span class="label">Nama :</span> Profil Edho Bima Putra</h2>
        <h2><span class="label">NIM  :</span> 24.12.3245</h2>
        <h2><span class="label">Hobi :</span> Belajar</h2>
    </div>

</body>
</html>