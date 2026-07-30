<?php

namespace App\Http\Controllers;

use App\Models\Organizer;

class OrganizerProfileController extends Controller
{
    public function show(Organizer $organizer)
    {
        $organizer->load(['events' => function ($q) {
            $q->withCount('reviews')->withAvg('reviews', 'rating');
        }]);

        // Ulasan terbaru dari seluruh event milik penyelenggara ini
        $latestReviews = $organizer->reviews()
            ->with(['user', 'event'])
            ->latest()
            ->take(10)
            ->get();

        return view('organizer.profile', compact('organizer', 'latestReviews'));
    }
}