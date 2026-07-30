<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Transaction;

class EventController extends Controller
{
    public function showDetail()
    {
        return view('event-detail');
    }

    public function anies()
    {
        return view('checkout');
    }

    public function ticket(Transaction $transaction)
    {
        return view('ticket', compact('transaction'));
    }

    // Daftar semua event yang pernah dibeli user yang sedang login,
// termasuk event yang sudah kadaluarsa & hilang dari listing Home,
// supaya user tetap bisa menemukan & memberi rating tanpa harus
// tahu URL/ID event-nya secara manual.
public function myTickets()
{
    $user = auth()->user();

    $transactions = Transaction::with(['event.reviews'])
        ->where('customer_email', $user->email)
        ->whereIn('status', ['success', 'settlement', 'capture'])
        ->latest()
        ->get();

    // Satu user bisa punya beberapa transaksi untuk event yang sama,
    // jadi ambil event unik saja lalu urutkan dari yang terbaru
    $events = $transactions->pluck('event')
        ->filter()
        ->unique('id')
        ->sortByDesc('date')
        ->map(function ($event) use ($user) {
            $event->already_reviewed = $event->reviews->contains('user_id', $user->id);
            $event->can_review = $event->isReviewable() && ! $event->already_reviewed;
            return $event;
        });

    return view('my-tickets', compact('events'));
}

    public function indexAdmin()
    {
        return view('admin.events');
    }

    public function show(Event $event)
    {
        $categories = Category::all();

        $event->load(['organizer', 'reviews' => function ($q) {
            $q->with('user')->latest();
        }]);

        $canReview = false;
        $alreadyReviewed = false;

        if (auth()->check()) {
            $alreadyReviewed = $event->reviews->contains('user_id', auth()->id());

            $isBuyer = Transaction::where('event_id', $event->id)
                ->where('customer_email', auth()->user()->email)
                ->whereIn('status', ['success', 'settlement', 'capture'])
                ->exists();

            $canReview = $event->isReviewable() && $isBuyer && ! $alreadyReviewed;
        }

        return view('event-detail', compact('categories', 'event', 'canReview', 'alreadyReviewed'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'category_id'  => 'required',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'date'         => 'required|date',
            'location'     => 'required|string|max:255',
            'price'        => 'required|numeric',
            'stock'        => 'required|numeric',
        ]);

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Rincian data event berhasil diperbarui.');
    }
}