@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-16">

    <div class="text-sm text-slate-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
        <span class="mx-2">/</span>
        <span class="text-slate-700 font-medium">{{ $organizer->name }}</span>
    </div>

    <!-- Header profil -->
    <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-14">
        <img src="{{ ($organizer->logo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($organizer->logo_path))
                ? asset('storage/' . $organizer->logo_path)
                : 'https://placehold.co/160x160?text=' . urlencode(substr($organizer->name, 0, 1)) }}"
            alt="{{ $organizer->name }}"
            class="w-28 h-28 rounded-3xl object-cover shadow-lg border-4 border-white">

        <div>
            <h1 class="text-3xl font-black text-slate-900 mb-2">{{ $organizer->name }}</h1>

            <div class="flex items-center gap-3">
                @if($organizer->reviews_count > 0)
                    <div class="flex items-center gap-1 text-amber-500">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($organizer->average_rating) ? 'fill-amber-400' : 'fill-slate-200' }}" viewBox="0 0 20 20"><path d="M10 15.27L16.18 19l-1.64-7.03L20 7.24l-7.19-.61L10 0 7.19 6.63 0 7.24l5.46 4.73L3.82 19z"/></svg>
                        @endfor
                    </div>
                    <span class="font-bold text-slate-700">{{ $organizer->average_rating }}</span>
                    <span class="text-slate-400 text-sm">dari {{ $organizer->reviews_count }} ulasan</span>
                @else
                    <span class="text-slate-400 text-sm">Belum ada ulasan dari peserta</span>
                @endif
            </div>

            @if($organizer->description)
                <p class="text-slate-500 mt-3 max-w-xl">{{ $organizer->description }}</p>
            @endif
        </div>
    </div>

    <!-- Daftar event yang diselenggarakan -->
    <h2 class="text-xl font-black text-slate-900 mb-6">Acara yang Diselenggarakan</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
        @forelse($organizer->events as $event)
            <a href="{{ route('events.show', $event->id) }}" class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <p class="font-bold text-slate-800 mb-1">{{ $event->title }}</p>
                <p class="text-xs text-slate-400 mb-3">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</p>
                <div class="flex items-center gap-1 text-amber-400 text-sm">
                    @if($event->reviews_count > 0)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15.27L16.18 19l-1.64-7.03L20 7.24l-7.19-.61L10 0 7.19 6.63 0 7.24l5.46 4.73L3.82 19z"/></svg>
                        <span class="font-semibold text-slate-700">{{ round($event->reviews_avg_rating, 1) }}</span>
                        <span class="text-slate-400">({{ $event->reviews_count }})</span>
                    @else
                        <span class="text-slate-400">Belum ada ulasan</span>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-slate-400 italic">Belum ada acara.</p>
        @endforelse
    </div>

    <!-- Testimoni terbaru -->
    <h2 class="text-xl font-black text-slate-900 mb-6">Testimoni Terbaru</h2>
    <div class="max-w-3xl">
        @forelse($latestReviews as $review)
            <div class="flex gap-4 py-6 border-b border-slate-100">
                <div class="w-11 h-11 shrink-0 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center">
                    {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <p class="font-bold text-slate-800">{{ $review->user->name ?? 'Peserta' }}</p>
                        <span class="text-xs text-slate-400">{{ $review->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <p class="text-xs text-indigo-500 font-medium mb-1">{{ $review->event->title ?? '' }}</p>
                    <div class="flex items-center gap-0.5 my-1 text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-amber-400' : 'fill-slate-200' }}" viewBox="0 0 20 20"><path d="M10 15.27L16.18 19l-1.64-7.03L20 7.24l-7.19-.61L10 0 7.19 6.63 0 7.24l5.46 4.73L3.82 19z"/></svg>
                        @endfor
                    </div>
                    @if($review->comment)
                        <p class="text-slate-600 leading-relaxed">{{ $review->comment }}</p>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-slate-400 italic">Belum ada testimoni untuk penyelenggara ini.</p>
        @endforelse
    </div>

</main>
@endsection