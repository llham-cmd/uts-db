<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Check-in Scanner - AmikomEventHub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #qr-reader {
            border: none !important;
        }

        #qr-reader video {
            border-radius: 1.5rem;
            object-fit: cover;
        }

        /* Sembunyikan UI bawaan html5-qrcode yang tidak dipakai (pilihan file upload, dsb) */
        #qr-reader__dashboard_section_csr,
        #qr-reader__header_message {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-900 text-white min-h-screen flex flex-col">

    <!-- Header -->
    <header class="p-5 flex items-center justify-between bg-slate-950">
        <div>
            <h1 class="font-black text-lg">Check-in Scanner</h1>
            <p class="text-slate-400 text-xs">Panitia Registrasi &middot; AmikomEventHub</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-slate-400 text-sm font-bold hover:text-white">Tutup ✕</a>
    </header>

    <!-- Kamera / QR Reader -->
    <main class="flex-1 flex flex-col items-center justify-center p-5">
        <div class="w-full max-w-sm">
            <div id="qr-reader" class="w-full rounded-3xl overflow-hidden bg-black"></div>

            <p id="scan-hint" class="text-center text-slate-400 text-sm mt-4">
                Arahkan kamera ke QR code pada e-tiket peserta
            </p>

            <div class="mt-4 flex items-center justify-center gap-3 text-sm">
                <span id="scan-counter" class="text-slate-400">Total scan sukses: <b class="text-white">0</b></span>
            </div>
        </div>
    </main>

    <!-- Overlay hasil scan (full screen, warna sesuai status) -->
    <div id="result-overlay" class="fixed inset-0 z-50 hidden flex-col items-center justify-center p-8 text-center">
        <div id="result-icon" class="w-24 h-24 rounded-full flex items-center justify-center mb-6 bg-white/20"></div>
        <h2 id="result-title" class="text-3xl font-black mb-2"></h2>
        <p id="result-message" class="text-lg opacity-90 mb-6"></p>

        <div id="result-detail" class="bg-white/10 rounded-2xl p-5 w-full max-w-sm text-left space-y-2 mb-8 hidden">
            <p><span class="opacity-70">Nama:</span> <b id="detail-nama"></b></p>
            <p><span class="opacity-70">Event:</span> <b id="detail-event"></b></p>
            <p><span class="opacity-70">Order ID:</span> <b id="detail-order"></b></p>
            <p><span class="opacity-70">Waktu Check-in:</span> <b id="detail-waktu"></b></p>
        </div>

        <button id="scan-next-btn"
            class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-black shadow-lg">
            Lanjut Scan Berikutnya
        </button>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const scanUrl = "{{ route('admin.checkin.scan') }}";

        let successCount = 0;
        let isProcessing = false; // mencegah scan yang sama diproses berkali-kali secara beruntun

        const html5QrCode = new Html5Qrcode("qr-reader");

        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
        };

        function startScanner() {
            html5QrCode.start(
                { facingMode: "environment" }, // pakai kamera belakang HP
                config,
                onScanSuccess,
                () => {} // callback error per-frame, diabaikan (normal terjadi terus saat tidak ada QR di layar)
            ).catch((err) => {
                document.getElementById('scan-hint').textContent =
                    'Gagal mengakses kamera. Pastikan izin kamera diaktifkan. (' + err + ')';
            });
        }

        async function onScanSuccess(decodedText) {
            if (isProcessing) return; // abaikan hasil scan tambahan selagi masih memproses yang sebelumnya
            isProcessing = true;

            // Hentikan sementara supaya QR yang sama tidak ke-scan berkali-kali beruntun
            try { await html5QrCode.pause(true); } catch (e) {}

            try {
                const response = await fetch(scanUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ code: decodedText }),
                });

                const result = await response.json();
                showResult(result);

                if (result.status === 'success') {
                    successCount++;
                    document.querySelector('#scan-counter b').textContent = successCount;
                }
            } catch (e) {
                showResult({
                    status: 'invalid',
                    message: 'Gagal terhubung ke server. Cek koneksi internet.',
                });
            }
        }

        function showResult(result) {
            const overlay = document.getElementById('result-overlay');
            const icon = document.getElementById('result-icon');
            const title = document.getElementById('result-title');
            const message = document.getElementById('result-message');
            const detail = document.getElementById('result-detail');

            const themes = {
                success: { bg: 'bg-green-600', icon: '✓', title: 'Check-in Berhasil' },
                used:    { bg: 'bg-rose-600',  icon: '✕', title: 'Tiket Sudah Dipakai!' },
                unpaid:  { bg: 'bg-orange-500', icon: '!', title: 'Belum Lunas' },
                invalid: { bg: 'bg-slate-700', icon: '?', title: 'QR Tidak Valid' },
            };

            const theme = themes[result.status] || themes.invalid;

            overlay.className = 'fixed inset-0 z-50 flex flex-col items-center justify-center p-8 text-center ' + theme.bg;
            icon.textContent = theme.icon;
            icon.className = 'w-24 h-24 rounded-full flex items-center justify-center mb-6 bg-white/20 text-5xl font-black';
            title.textContent = theme.title;
            message.textContent = result.message;

            if (result.data) {
                document.getElementById('detail-nama').textContent = result.data.nama ?? '-';
                document.getElementById('detail-event').textContent = result.data.event ?? '-';
                document.getElementById('detail-order').textContent = result.data.order_id ?? '-';
                document.getElementById('detail-waktu').textContent = result.data.checked_in_at ?? '-';
                detail.classList.remove('hidden');
            } else {
                detail.classList.add('hidden');
            }

            // Getar HP sebagai feedback tambahan (kalau device support)
            if (navigator.vibrate) {
                navigator.vibrate(result.status === 'success' ? 150 : [100, 80, 100]);
            }
        }

        document.getElementById('scan-next-btn').addEventListener('click', async () => {
            document.getElementById('result-overlay').classList.add('hidden');
            isProcessing = false;
            try { await html5QrCode.resume(); } catch (e) {}
        });

        startScanner();
    </script>

</body>

</html>