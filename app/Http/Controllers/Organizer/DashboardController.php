<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $organizer = Auth::user()->organizer;

        $totalEvents = $organizer->events()->count();
        $activeEvents = $organizer->events()->where('date', '>=', now())->count();

        $eventIds = $organizer->events()->pluck('id');

        $ticketsSold = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->count();

        $totalRevenue = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

        return view('organizer.dashboard', compact(
            'totalEvents',
            'activeEvents',
            'ticketsSold',
            'totalRevenue'
        ));
    }
}