@extends('layouts.admin')
@section('title', 'Kelola Partner - Admin')
@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Tambah dan atur daftar partner event.')

@section('content')

@if(session('success'))
<div class="mb-4 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-medium flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Search Bar --}}
<div class="mb-4 flex items-center gap-3">
    <form method="GET" action="{{ route('admin.partners.index') }}" class="flex gap-2 w-full max-w-md">
        <input type="text" name="search" value="{{ $search ?? '' }}"
            placeholder="Cari nama partner..."
            class="w-full px-5 py-3 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
        <button type="submit"
            class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
            Cari
        </button>
        @if($search)
        <a href="{{ route('admin.partners.index') }}"
            class="px-5 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">
            Reset
        </a>
        @endif
    </form>
</div>

<div class="mb-4 text-right">
    <a href="{{ route('admin.partners.create') }}"
        class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Partner
    </a>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4">Dibuat Pada</th>
                    <th class="px-8 py-4">Diperbarui Pada</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">{{ $partners->firstItem() + $index }}</td>
                    <td class="px-8 py-5">
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}"
                            class="h-10 w-auto max-w-[80px] object-contain rounded-lg border border-slate-100 bg-slate-50 p-1"
                            onerror="this.src='https://placehold.co/80x40?text=Logo'">
                    </td>
                    <td class="px-8 py-5 font-black text-slate-800">{{ $partner->name }}</td>
                    <td class="px-8 py-5 text-slate-400 text-sm">{{ $partner->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-8 py-5 text-slate-400 text-sm">{{ $partner->updated_at->format('d M Y, H:i') }}</td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus partner ini?');">
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
                        Belum ada partner. Tambahkan partner pertama!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-slate-50/50 border-t">
        {{ $partners->links() }}
    </div>
</div>
@endsection