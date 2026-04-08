<?php

namespace App\Http\Controllers;

use App\Models\JenisZakat;
use Illuminate\Http\Request;

class JenisZakatController extends Controller
{
    /**
     * Papar senarai semua jenis zakat.
     */
    public function index()
    {
        $jenisZakats = JenisZakat::withCount('pembayarans')->orderBy('nama')->get();

        return view('jenis-zakat.index', compact('jenisZakats'));
    }

    /**
     * Papar borang tambah jenis zakat baru.
     */
    public function create()
    {
        return view('jenis-zakat.create');
    }

    /**
     * Simpan jenis zakat baru ke pangkalan data.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kadar' => 'required|numeric|min:0',
            'penerangan' => 'nullable|string',
            'is_aktif' => 'boolean',
        ], [
            'nama.required' => 'Nama jenis zakat wajib diisi.',
            'kadar.required' => 'Kadar zakat wajib diisi.',
            'kadar.numeric' => 'Kadar mestilah nombor.',
            'kadar.min' => 'Kadar tidak boleh negatif.',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');

        JenisZakat::create($validated);

        return redirect()->route('jenis-zakat.index')
            ->with('success', 'Jenis zakat berjaya ditambah.');
    }

    /**
     * Papar maklumat terperinci jenis zakat.
     */
    public function show(JenisZakat $jenisZakat)
    {
        $jenisZakat->loadCount('pembayarans');

        return view('jenis-zakat.show', compact('jenisZakat'));
    }

    /**
     * Papar borang kemaskini jenis zakat.
     */
    public function edit(JenisZakat $jenisZakat)
    {
        return view('jenis-zakat.edit', compact('jenisZakat'));
    }

    /**
     * Kemaskini maklumat jenis zakat.
     */
    public function update(Request $request, JenisZakat $jenisZakat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kadar' => 'required|numeric|min:0',
            'penerangan' => 'nullable|string',
            'is_aktif' => 'boolean',
        ], [
            'nama.required' => 'Nama jenis zakat wajib diisi.',
            'kadar.required' => 'Kadar zakat wajib diisi.',
            'kadar.numeric' => 'Kadar mestilah nombor.',
            'kadar.min' => 'Kadar tidak boleh negatif.',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');

        $jenisZakat->update($validated);

        return redirect()->route('jenis-zakat.index')
            ->with('success', 'Jenis zakat berjaya dikemaskini.');
    }

    /**
     * Padam jenis zakat dari pangkalan data.
     */
    public function destroy(JenisZakat $jenisZakat)
    {
        $jenisZakat->delete();

        return redirect()->route('jenis-zakat.index')
            ->with('success', 'Jenis zakat berjaya dipadam.');
    }
}
