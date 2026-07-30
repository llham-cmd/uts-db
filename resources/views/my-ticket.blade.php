@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900">Tiket Saya</h1>
        <p class="text-slate-500 mt-1">Daftar event yang pernah kamu ikuti. Beri rating untuk event yang sudah selesai.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl px-5 py-3 mb-6 font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 text-rose-700 border border-rose-200 rounded-2xl px-5 py-3 mb-6 font-medium">
            {{ session('error') }}
        </div>
    @endif

    @forelse($events as $event)
        <div class="bg-white border border-slate-100 rounded-3xl shadow-sm p-5 mb-4 flex flex-col sm:flex-row gap-5 items-start sm:items-center">

            <img src="{{ ($event->poster_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path)) ? asset('storage/' . $event->poster_path) : 'https://placehold.co/120x120?text=Event' }}"
                 alt="{{ $event->title }}"
                 class="w-full sm:w-24 h-24 object-cover rounded-2xl">

            <div class="flex-1">
                <h2 class="text-lg font-bold text-slate-900">{{ $event->title }}</h2>
                <p class="text-sm text-slate-500 flex items-center gap-1 mt-1">
                    {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y, H:i') }}
                </p>

                {{-- Status badge --}}
                @if($event->already_reviewed)
                    <span class="inline-block mt-2 text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-500">
                        Sudah kamu ulas
                    </span>
                @elseif($event->can_review)
                    <span class="inline-block mt-2 text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-700">
                        Menunggu ulasan kamu
                    </span>
                @elseif($event->isReviewable())
                    <span class="inline-block mt-2 text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-500">
                        Event telah selesai
                    </span>
                @else
                    <span class="inline-block mt-2 text-xs font-semibold px-3 py-1 rounded-full bg-indigo-50 text-indigo-600">
                        Akan datang
                    </span>
                @endif
            </div>

            <div class="w-full sm:w-auto">
                @if($event->can_review)
                    <a href="{{ route('events.show', $event->id) }}#ulasan"
                       class="block text-center w-full sm:w-auto bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition">
                        Beri Rating
                    </a>
                @else
                    <a href="{{ route('events.show', $event->id) }}"
                       class="block text-center w-full sm:w-auto bg-slate-100 text-slate-600 font-semibold px-5 py-2.5 rounded-xl hover:bg-slate-200 transition">
                        Lihat Detail
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-20">
            <p class="text-slate-400">Kamu belum pernah membeli tiket event apapun.</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 text-indigo-600 font-semibold hover:underline">
                Jelajahi event sekarang &rarr;
            </a>
        </div>
    @endforelse

</div>
@endsection