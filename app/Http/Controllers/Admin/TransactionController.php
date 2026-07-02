<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil transaksi terbaru dengan pembatasan 20 baris/halaman
        $transactions = Transaction::with('event')->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(Transaction $transaction)
    {
        $transaction->update(['status' => 'success']);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Status transaksi berhasil diperbarui menjadi Lunas.');
    }
}
