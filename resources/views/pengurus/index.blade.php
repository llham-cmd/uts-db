@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Data Pengurus</h1>
        <a href="{{ route('pengurus.create') }}"
            class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
            + Tambah Pengurus
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-100 text-green-800 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass rounded-2xl border border-white/20 shadow-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-indigo-50">
                <tr>
                    <th class="px-6 py-4 font-semibold text-slate-700">#</th>
                    <th class="px-6 py-4 font-semibold text-slate-700">Nama Pengurus</th>
                    <th class="px-6 py-4 font-semibold text-slate-700">Jabatan</th>
                    <th class="px-6 py-4 font-semibold text-slate-700">Gaji</th>
                    <th class="px-6 py-4 font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penguruses as $pengurus)
                <tr class="border-t border-slate-200 hover:bg-slate-50 transition">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium">{{ $pengurus->name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-medium">
                            {{ $pengurus->jabatan->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Rp{{ number_format($pengurus->salary, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('pengurus.edit', $pengurus->id) }}"
                            class="px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-semibold hover:bg-amber-600 transition">
                            Edit
                        </a>
                        <form action="{{ route('pengurus.destroy', $pengurus->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada data pengurus.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $penguruses->links() }}
    </div>
</div>
@endsection