@extends('layouts.organizer')
@section('title', 'Dashboard Organizer')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan performa event Anda')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
        <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="text-slate-400 text-[11px] font-black uppercase tracking-widest">Total Event</p>
        <p class="text-3xl font-black mt-1">{{ $totalEvents }}</p>
    </div>
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
        <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-slate-400 text-[11px] font-black uppercase tracking-widest">Event Aktif</p>
        <p class="text-3xl font-black mt-1">{{ $activeEvents }}</p>
    </div>
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
        <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <p class="text-slate-400 text-[11px] font-black uppercase tracking-widest">Tiket Terjual</p>
        <p class="text-3xl font-black mt-1">{{ $ticketsSold }}</p>
    </div>
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
        <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m8-10v10a2 2 0 01-2 2H9m8-10V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2"/>
            </svg>
        </div>
        <p class="text-slate-400 text-[11px] font-black uppercase tracking-widest">Total Pendapatan</p>
        <p class="text-2xl font-black mt-1">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<a href="{{ route('organizer.events.index') }}"
    class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3.5 rounded-2xl font-black shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
    Kelola Event Saya
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
    </svg>
</a>
@endsection