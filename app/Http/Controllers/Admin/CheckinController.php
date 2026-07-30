<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    // Menampilkan halaman scanner QR (dipakai panitia registrasi di hari-H)
    public function index()
    {
        return view('admin.checkin');
    }

    // Endpoint yang dipanggil JS setiap kali kamera berhasil membaca satu QR code
    public function scan(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // QR berisi ticket_code (UUID unik per transaksi, bukan order_id)
        $transaction = Transaction::with('event')
            ->where('ticket_code', $request->input('code'))
            ->first();

        // 1. QR tidak dikenali sama sekali → kemungkinan palsu/rusak
        if (!$transaction) {
            return response()->json([
                'status'  => 'invalid',
                'message' => 'QR tidak valid atau tiket tidak ditemukan.',
            ], 404);
        }

        // 2. Tiket ditemukan tapi belum lunas (masih pending/expired/gagal)
        if (!$transaction->isPaid()) {
            return response()->json([
                'status'  => 'unpaid',
                'message' => 'Tiket ini belum dibayar (status: ' . $transaction->status . ').',
                'data'    => $this->ticketPayload($transaction),
            ], 409);
        }

        // 3. Anti-kecurangan: tiket sudah pernah dipakai check-in sebelumnya (double entry)
        if ($transaction->is_checked_in) {
            return response()->json([
                'status'  => 'used',
                'message' => 'Tiket ini SUDAH digunakan untuk check-in sebelumnya!',
                'data'    => $this->ticketPayload($transaction),
            ], 409);
        }

        // 4. Sah & belum pernah dipakai → tandai sebagai used, catat waktu & petugasnya
        $transaction->update([
            'is_checked_in'  => true,
            'checked_in_at'  => now(),
            'checked_in_by'  => $request->user()->id,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Check-in berhasil. Selamat datang!',
            'data'    => $this->ticketPayload($transaction->fresh('event')),
        ]);
    }

    private function ticketPayload(Transaction $transaction): array
    {
        return [
            'nama'          => $transaction->customer_name,
            'email'         => $transaction->customer_email,
            'event'         => $transaction->event->title ?? '-',
            'order_id'      => $transaction->order_id,
            'checked_in_at' => optional($transaction->checked_in_at)->format('d M Y, H:i'),
        ];
    }
}