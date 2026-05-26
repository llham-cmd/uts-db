<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori beserta jumlah event-nya (untuk filter tab button)
        $categories = Category::withCount('events')->get();

        // 2. Ambil semua partner
        $partners = Partner::all();

        // 3. Buat kueri dasar untuk mengambil event:
        // - Eager loading relasi `category`
        // - Hanya tampilkan event yang belum kedaluwarsa (>= hari ini)
        // - Urutkan berdasarkan tanggal terdekat
        $query = Event::with('category')
                      ->where('date', '>=', now())
                      ->orderBy('date', 'asc');

        // 4. Filter berdasarkan kategori jika ada parameter ?category= di URL
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 5. Eksekusi query
        $events = $query->get();

        // 6. Kirim semua data ke view
        return view('welcome', compact('events', 'categories', 'partners'));
    }
}