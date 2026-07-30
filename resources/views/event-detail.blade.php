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

            <!-- Rating rata-rata + link penyelenggara -->
            <div class="flex items-center gap-3 mb-6 flex-wrap">
                @if($event->reviews_count > 0)
                    <div class="flex items-center gap-1 text-amber-500">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($event->average_rating) ? 'fill-amber-400' : 'fill-slate-200' }}" viewBox="0 0 20 20"><path d="M10 15.27L16.18 19l-1.64-7.03L20 7.24l-7.19-.61L10 0 7.19 6.63 0 7.24l5.46 4.73L3.82 19z"/></svg>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ $event->average_rating }}</span>
                    <span class="text-sm text-slate-400">({{ $event->reviews_count }} ulasan)</span>
                @else
                    <span class="text-sm text-slate-400">Belum ada ulasan</span>
                @endif

                @if($event->organizer)
                    <span class="text-slate-300">•</span>
                    <a href="{{ route('organizer.profile', $event->organizer->slug) }}" class="text-sm font-semibold text-indigo-600 hover:underline">
                        Diselenggarakan oleh {{ $event->organizer->name }}
                    </a>
                @endif
            </div>

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

    <!-- ─── Ulasan & Penilaian Bintang ─────────────────────────── -->
    <section id="ulasan" class="mt-20 max-w-4xl">
        <h2 class="text-2xl font-black text-slate-900 mb-2">Ulasan Peserta</h2>
        <p class="text-slate-500 mb-8">Testimoni jujur dari peserta yang telah menghadiri acara ini.</p>

        @if(session('success'))
            <div class="mb-6 px-5 py-4 bg-emerald-50 text-emerald-700 rounded-2xl font-medium">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-5 py-4 bg-rose-50 text-rose-700 rounded-2xl font-medium">{{ session('error') }}</div>
        @endif

        @auth
            @if($canReview)
                <form method="POST" action="{{ route('reviews.store', $event->id) }}" class="bg-white border border-slate-100 rounded-3xl shadow-sm p-8 mb-10">
                    @csrf
                    <p class="font-bold text-slate-800 mb-3">Beri rating kamu</p>

                    <div class="flex flex-row-reverse justify-end gap-1 mb-5" title="Pilih rating bintang">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="peer hidden" {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label for="star{{ $i }}" class="cursor-pointer text-3xl text-slate-200 peer-checked:text-amber-400 hover:text-amber-400 transition">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20"><path d="M10 15.27L16.18 19l-1.64-7.03L20 7.24l-7.19-.61L10 0 7.19 6.63 0 7.24l5.46 4.73L3.82 19z"/></svg>
                            </label>
                        @endfor
                    </div>
                    @error('rating') <p class="text-rose-500 text-sm mb-3">{{ $message }}</p> @enderror

                    <textarea name="comment" rows="3" maxlength="1000" placeholder="Bagaimana pengalamanmu di acara ini? (opsional)"
                        class="w-full border border-slate-200 rounded-2xl p-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('comment') }}</textarea>
                    @error('comment') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror

                    <button type="submit" class="mt-4 px-8 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
                        Kirim Ulasan
                    </button>
                </form>
            @elseif($alreadyReviewed)
                <div class="mb-10 px-5 py-4 bg-indigo-50 text-indigo-700 rounded-2xl font-medium">
                    Kamu sudah memberikan ulasan untuk acara ini. Terima kasih!
                </div>
            @endif
        @endauth

        @forelse($event->reviews as $review)
            <div class="flex gap-4 py-6 border-b border-slate-100">
                <div class="w-11 h-11 shrink-0 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center">
                    {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <p class="font-bold text-slate-800">{{ $review->user->name ?? 'Peserta' }}</p>
                        <span class="text-xs text-slate-400">{{ $review->created_at->translatedFormat('d F Y') }}</span>
                    </div>
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
            <p class="text-slate-400 italic">Belum ada ulasan untuk acara ini.</p>
        @endforelse
    </section>
</main>
@endsection