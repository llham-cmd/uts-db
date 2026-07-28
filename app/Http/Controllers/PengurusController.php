<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $penguruses = Pengurus::with('jabatan')->latest()->paginate(10);
        return view('pengurus.index', compact('penguruses'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        return view('pengurus.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = auth()->user()->name ?? 'system';

        Pengurus::create($validated);

        return redirect()->route('pengurus.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(Pengurus $pengurus)
    {
        $jabatans = Jabatan::all();
        return view('pengurus.edit', compact('pengurus', 'jabatans'));
    }

    public function update(Request $request, Pengurus $pengurus)
    {
        $validated = $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'salary' => 'required|numeric|min:0',
        ]);

        $validated['updated_by'] = auth()->user()->name ?? 'system';

        $pengurus->update($validated);

        return redirect()->route('pengurus.index')->with('success', 'Pengurus berhasil diperbarui.');
    }

    public function destroy(Pengurus $pengurus)
    {
        $pengurus->delete();
        return redirect()->route('pengurus.index')->with('success', 'Pengurus berhasil dihapus.');
    }
}