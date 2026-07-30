<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Status transaksi yang dianggap "lunas / berhasil"
    protected array $paidStatuses = ['success', 'settlement', 'capture'];

    public function store(Request $request, Event $event)
    {
        $user = Auth::user();

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Silakan pilih rating bintang terlebih dahulu.',
        ]);

        // 1. Event harus sudah tuntas + lewat H+1 sebelum bisa diulas
        if (! $event->isReviewable()) {
            return back()->with('error', 'Ulasan baru bisa diberikan sehari setelah acara berlangsung.');
        }

        // 2. User harus benar-benar pembeli tiket event ini (dicocokkan via email, transaksi tidak menyimpan user_id)
        $isBuyer = Transaction::where('event_id', $event->id)
            ->where('customer_email', $user->email)
            ->whereIn('status', $this->paidStatuses)
            ->exists();

        if (! $isBuyer) {
            return back()->with('error', 'Hanya pembeli tiket yang sudah menyelesaikan transaksi yang dapat memberi ulasan.');
        }

        // 3. Cegah ulasan ganda dari user yang sama untuk event yang sama
        $alreadyReviewed = $event->reviews()->where('user_id', $user->id)->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk acara ini.');
        }

        $event->reviews()->create([
            'user_id' => $user->id,
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan dan rating kamu berhasil dikirim.');
    }
}