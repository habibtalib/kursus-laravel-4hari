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
        $this->authorize('viewAny', JenisZakat::class);

        $jenisZakats = JenisZakat::withCount('pembayarans')->orderBy('nama')->get();

        return view('jenis-zakat.index', compact('jenisZakats'));
    }

    /**
     * Papar borang tambah jenis zakat baru.
     */
    public function create()
    {
        $this->authorize('create', JenisZakat::class);

        return view('jenis-zakat.create');
    }

    /**
     * Simpan jenis zakat baru ke pangkalan data.
     */
    public function store(Request $request)
    {
        $this->authorize('create', JenisZakat::class);

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
        $this->authorize('view', $jenisZakat);

        $jenisZakat->loadCount('pembayarans');

        return view('jenis-zakat.show', compact('jenisZakat'));
    }

    /**
     * Papar borang kemaskini jenis zakat.
     */
    public function edit(JenisZakat $jenisZakat)
    {
        $this->authorize('update', $jenisZakat);

        return view('jenis-zakat.edit', compact('jenisZakat'));
    }

    /**
     * Kemaskini maklumat jenis zakat.
     */
    public function update(Request $request, JenisZakat $jenisZakat)
    {
        $this->authorize('update', $jenisZakat);

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
        $this->authorize('delete', $jenisZakat);

        $jenisZakat->delete();

        return redirect()->route('jenis-zakat.index')
            ->with('success', 'Jenis zakat berjaya dipadam.');
    }
}
