@extends('layouts.organizer')
@section('title', 'Event Saya')
@section('page_title', 'Event Saya')
@section('page_subtitle', 'Kelola semua event yang Anda selenggarakan')

@section('content')
<div class="mb-4 text-right">
    <a href="{{ route('organizer.events.create') }}"
        class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Event
    </a>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Judul</th>
                    <th class="px-8 py-4">Kategori</th>
                    <th class="px-8 py-4">Tanggal</th>
                    <th class="px-8 py-4">Harga</th>
                    <th class="px-8 py-4">Stok</th>
                    <th class="px-8 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($events as $event)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-black text-slate-800">{{ $event->title }}</td>
                    <td class="px-8 py-5 text-slate-500 text-sm">{{ $event->category->name ?? '-' }}</td>
                    <td class="px-8 py-5 text-slate-400 text-sm">{{ $event->date->format('d M Y') }}</td>
                    <td class="px-8 py-5 text-slate-600 text-sm font-bold">Rp{{ number_format($event->price, 0, ',', '.') }}</td>
                    <td class="px-8 py-5 text-slate-600 text-sm">{{ $event->stock }}</td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('organizer.events.edit', $event) }}"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('organizer.events.destroy', $event) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus event ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400">
                        Anda belum punya event. Yuk buat yang pertama!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-slate-50/50 border-t">
        {{ $events->links() }}
    </div>
</div>
@endsection