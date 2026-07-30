@extends('layouts.admin')
@section('title', 'Kelola Organizer - Admin')
@section('page_title', 'Kelola Organizer')
@section('page_subtitle', 'Tinjau dan setujui pendaftaran organizer baru.')

@section('content')

@if(session('success'))
<div class="mb-4 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-medium flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Nama Organizer</th>
                    <th class="px-8 py-4">Email Akun</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4">Terdaftar</th>
                    <th class="px-8 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($organizers as $index => $organizer)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-5 font-bold text-slate-400">{{ $organizers->firstItem() + $index }}</td>
                    <td class="px-8 py-5 font-black text-slate-800">{{ $organizer->name }}</td>
                    <td class="px-8 py-5 text-slate-500 text-sm">{{ $organizer->user->email ?? '-' }}</td>
                    <td class="px-8 py-5">
                        @if($organizer->is_approved)
                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-full text-xs font-black">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Disetujui
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-3 py-1.5 rounded-full text-xs font-black">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Menunggu
                        </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-slate-400 text-sm">{{ $organizer->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-8 py-5">
                        <div class="flex gap-2 justify-end">
                            @if(!$organizer->is_approved)
                            <form action="{{ route('admin.organizers.approve', $organizer) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                                    title="Setujui organizer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </form>
                            <form action="{{ route('admin.organizers.reject', $organizer) }}" method="POST"
                                onsubmit="return confirm('Tolak pendaftaran organizer \'{{ $organizer->name }}\'? Data organizer ini akan dihapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                    title="Tolak organizer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                            @else
                            <span class="px-3 py-2 text-slate-300 text-xs font-bold italic">Sudah aktif</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400">
                        Belum ada organizer yang mendaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-slate-50/50 border-t">
        {{ $organizers->links() }}
    </div>
</div>
@endsection