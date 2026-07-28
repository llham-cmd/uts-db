@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Tambah Jabatan</h1>

    <form action="{{ route('jabatan.store') }}" method="POST"
        class="glass p-8 rounded-2xl border border-white/20 shadow-lg space-y-6">
        @csrf

        <div>
            <label class="block font-semibold text-slate-700 mb-2">Nama Jabatan</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                Simpan
            </button>
            <a href="{{ route('jabatan.index') }}"
                class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection