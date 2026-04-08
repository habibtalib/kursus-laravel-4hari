<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pembayar;
use App\Models\JenisZakat;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Papar senarai semua pembayaran.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        $pembayarans = Pembayaran::with(['pembayar', 'jenisZakat'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByDesc('tarikh_bayar')
            ->paginate(10)
            ->withQueryString();

        return view('pembayaran.index', compact('pembayarans', 'status'));
    }

    /**
     * Papar borang tambah pembayaran baru.
     */
    public function create()
    {
        $pembayars = Pembayar::orderBy('nama')->get();
        $jenisZakats = JenisZakat::aktif()->orderBy('nama')->get();
        $noResit = 'ZK-' . date('Y') . '-' . str_pad(Pembayaran::count() + 1, 4, '0', STR_PAD_LEFT);

        return view('pembayaran.create', compact('pembayars', 'jenisZakats', 'noResit'));
    }

    /**
     * Simpan pembayaran baru ke pangkalan data.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pembayar_id' => 'required|exists:pembayars,id',
            'jenis_zakat_id' => 'required|exists:jenis_zakats,id',
            'jumlah' => 'required|numeric|min:1',
            'tarikh_bayar' => 'required|date',
            'cara_bayar' => 'required|in:tunai,kad,fpx,online',
            'no_resit' => 'required|string|unique:pembayarans,no_resit',
        ], [
            'pembayar_id.required' => 'Sila pilih pembayar.',
            'pembayar_id.exists' => 'Pembayar tidak sah.',
            'jenis_zakat_id.required' => 'Sila pilih jenis zakat.',
            'jenis_zakat_id.exists' => 'Jenis zakat tidak sah.',
            'jumlah.required' => 'Jumlah bayaran wajib diisi.',
            'jumlah.numeric' => 'Jumlah mestilah nombor.',
            'jumlah.min' => 'Jumlah minimum ialah RM 1.00.',
            'tarikh_bayar.required' => 'Tarikh bayar wajib diisi.',
            'tarikh_bayar.date' => 'Format tarikh tidak sah.',
            'cara_bayar.required' => 'Sila pilih cara bayar.',
            'cara_bayar.in' => 'Cara bayar tidak sah.',
            'no_resit.unique' => 'No. resit telah wujud.',
        ]);

        $validated['status'] = 'pending';

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berjaya ditambah.');
    }

    /**
     * Papar maklumat terperinci pembayaran.
     */
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['pembayar', 'jenisZakat']);

        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Papar borang kemaskini pembayaran.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $pembayars = Pembayar::orderBy('nama')->get();
        $jenisZakats = JenisZakat::aktif()->orderBy('nama')->get();

        return view('pembayaran.edit', compact('pembayaran', 'pembayars', 'jenisZakats'));
    }

    /**
     * Kemaskini maklumat pembayaran.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'pembayar_id' => 'required|exists:pembayars,id',
            'jenis_zakat_id' => 'required|exists:jenis_zakats,id',
            'jumlah' => 'required|numeric|min:1',
            'tarikh_bayar' => 'required|date',
            'cara_bayar' => 'required|in:tunai,kad,fpx,online',
            'status' => 'required|in:pending,sah,batal',
        ], [
            'pembayar_id.required' => 'Sila pilih pembayar.',
            'pembayar_id.exists' => 'Pembayar tidak sah.',
            'jenis_zakat_id.required' => 'Sila pilih jenis zakat.',
            'jenis_zakat_id.exists' => 'Jenis zakat tidak sah.',
            'jumlah.required' => 'Jumlah bayaran wajib diisi.',
            'jumlah.numeric' => 'Jumlah mestilah nombor.',
            'jumlah.min' => 'Jumlah minimum ialah RM 1.00.',
            'tarikh_bayar.required' => 'Tarikh bayar wajib diisi.',
            'tarikh_bayar.date' => 'Format tarikh tidak sah.',
            'cara_bayar.required' => 'Sila pilih cara bayar.',
            'cara_bayar.in' => 'Cara bayar tidak sah.',
            'status.required' => 'Sila pilih status.',
            'status.in' => 'Status tidak sah.',
        ]);

        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berjaya dikemaskini.');
    }

    /**
     * Padam pembayaran dari pangkalan data.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berjaya dipadam.');
    }
}
