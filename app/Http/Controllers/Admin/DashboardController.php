<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    // Opsi periode yang diizinkan untuk filter grafik
    private const ALLOWED_PERIODS = ['7d', '3m', '6m', '12m'];

    public function index(Request $request)
    {
        // 1. Menjumlahkan semua nominal total_price dari transaksi Lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');

        // 2. Jumlah tiket yang sudah Lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();

        // 3. Jumlah event yang tanggalnya masih akan datang
        $activeEvents = Event::where('date', '>=', now())->count();

        // 4. Transaksi yang masih pending
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. 5 transaksi terbaru
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        // 6. Periode filter untuk grafik (default 6 bulan)
        $period = $request->query('period', '6m');
        if (!in_array($period, self::ALLOWED_PERIODS)) {
            $period = '6m';
        }

        $userGrowth = $this->growthData(User::query(), $period);
        $eventGrowth = $this->growthData(Event::query(), $period);

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'userGrowth',
            'eventGrowth',
            'period'
        ));
    }

    /**
     * Router kecil: pilih strategi grouping berdasarkan periode yang dipilih.
     */
    private function growthData($query, string $period): array
    {
        if ($period === '7d') {
            return $this->dailyGrowth($query, 7);
        }

        $months = match ($period) {
            '3m'  => 3,
            '12m' => 12,
            default => 6, // '6m'
        };

        return $this->monthlyGrowth($query, $months);
    }

    /**
     * Hitung jumlah record baru per hari (created_at) untuk N hari terakhir,
     * termasuk hari yang datanya kosong (diisi 0).
     */
    private function dailyGrowth($query, int $days): array
    {
        $dates = collect(range($days - 1, 0))->map(fn ($i) => now()->subDays($i)->startOfDay());

        $raw = $query
            ->where('created_at', '>=', $dates->first())
            ->get()
            ->groupBy(fn ($row) => Carbon::parse($row->created_at)->format('Y-m-d'));

        $labels = [];
        $data = [];

        foreach ($dates as $date) {
            $key = $date->format('Y-m-d');
            $labels[] = $date->format('d M'); // contoh: "24 Jul"
            $data[] = $raw->get($key)?->count() ?? 0;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    /**
     * Hitung jumlah record baru per bulan (created_at) untuk N bulan terakhir,
     * termasuk bulan yang datanya kosong (diisi 0).
     */
    private function monthlyGrowth($query, int $months): array
    {
        $monthsList = collect(range($months - 1, 0))->map(fn ($i) => now()->subMonths($i)->startOfMonth());

        $raw = $query
            ->where('created_at', '>=', $monthsList->first())
            ->get()
            ->groupBy(fn ($row) => Carbon::parse($row->created_at)->format('Y-m'));

        $labels = [];
        $data = [];

        foreach ($monthsList as $month) {
            $key = $month->format('Y-m');
            $labels[] = $month->format('M Y'); // contoh: "Jul 2026"
            $data[] = $raw->get($key)?->count() ?? 0;
        }

        return ['labels' => $labels, 'data' => $data];
    }
}