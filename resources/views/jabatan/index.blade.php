@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Data Jabatan</h1>
        <a href="{{ route('jabatan.create') }}"
            class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
            + Tambah Jabatan
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
                    <th class="px-6 py-4 font-semibold text-slate-700">Nama Jabatan</th>
                    <th class="px-6 py-4 font-semibold text-slate-700">Dibuat Oleh</th>
                    <th class="px-6 py-4 font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jabatans as $jabatan)
                <tr class="border-t border-slate-200 hover:bg-slate-50 transition">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium">{{ $jabatan->name }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $jabatan->created_by }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('jabatan.edit', $jabatan->id) }}"
                            class="px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-semibold hover:bg-amber-600 transition">
                            Edit
                        </a>
                        <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST"
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
                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada data jabatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $jabatans->links() }}
    </div>
</div>
@endsection