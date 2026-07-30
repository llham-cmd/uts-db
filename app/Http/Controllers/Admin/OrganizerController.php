<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        $organizers = Organizer::with('user')->latest()->paginate(10);
        return view('admin.organizers.index', compact('organizers'));
    }

    public function approve(Organizer $organizer)
    {
        $organizer->update(['is_approved' => true]);
        return back()->with('success', "Organizer '{$organizer->name}' berhasil disetujui.");
    }

    public function reject(Organizer $organizer)
    {
        // Turunkan role user kembali jadi user biasa, lalu hapus profil organizer-nya
        $organizer->user->update(['role' => 'user']);
        $organizer->delete();

        return back()->with('success', 'Pendaftaran organizer berhasil ditolak.');
    }
}