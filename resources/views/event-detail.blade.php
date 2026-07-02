@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-16">

    <!-- Breadcrumb -->
    <div class="text-sm text-slate-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
        <span class="mx-2">/</span>
        <span class="text-slate-700 font-medium">{{ $event->title }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-10">

        <!-- Poster -->
        <div class="md:col-span-2">
            <img src="{{ ($event->poster_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path))
                    ? asset('storage/' . $event->poster_path)
                    : 'https://placehold.co/600x800?text=No+Image' }}"
                alt="{{ $event->title }}"
                class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">
        </div>

        <!-- Detail -->
        <div class="md:col-span-3 flex flex-col">

            @if($event->category)
                <span class="inline-block w-fit px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                    {{ $event->category->name }}
                </span>
            @endif

            <h1 class="text-4xl font-black text-slate-900 mb-4">{{ $event->title }}</h1>

            <div class="flex flex-wrap gap-6 mb-8 text-slate-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y, H:i') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-semibold">{{ $event->location }}</span>
                </div>
            </div>

            <div class="prose prose-slate mb-10 text-slate-600 leading-relaxed">
                {{ $event->description ?? 'Belum ada deskripsi untuk event ini.' }}
            </div>

            <!-- Kartu Beli Tiket -->
            <div class="mt-auto bg-white border border-slate-100 rounded-3xl shadow-sm p-8 flex items-center justify-between gap-6 flex-wrap">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">Harga Tiket</p>
                    <p class="text-3xl font-black text-indigo-600">
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-slate-400 mt-1">
                        Stok tersisa: <span class="font-bold text-slate-600">{{ $event->stock }}</span>
                    </p>
                </div>

                @if($event->stock > 0)
                    <a href="{{ route('checkout.create', $event->id) }}"
                        class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                        Beli Tiket
                    </a>
                @else
                    <span class="px-8 py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold cursor-not-allowed">
                        Tiket Habis
                    </span>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection