<?php

namespace App\Http\Controllers;

use App\Models\Absen_Qr;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Redirect;

class AbsenQrController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'absen';

        $keyword = trim($request->input('nama'));

        // cari nama dari relasi ke jadwal untuk cari mapel dan guru
        $absenqr = Absen_Qr::with('jadwal')
            ->when($keyword, function ($query, $name) {
                $query->whereHas('user', function ($q) use ($name) {
                    $q->where('name', 'like', '%' . $name . '%');
                });
            })
            ->latest()
            ->paginate(10);

        $absenqr->appends(['nama' => $keyword]);

        return view('pages.absenqr.index', compact('type_menu', 'guru'));
    }
    public function create()
    {
        $type_menu = 'absen';
        $jadwal = Jadwal::all();

        return view('pages.absenqr.create', compact('type_menu', 'jadwal'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'jadwal_id' => 'required',
            'tanggal_absen' => 'required|date',
            'token_qr' => 'required',
            'expired_at' => 'required',
        ]);

        $absenqr = Absen_Qr::create([
            'jadwal_id' => $request->jadwal_id,
            'tanggal_absen' => $request->tanggal_absen,
            'token_qr' => $request->token_qr,
            'expired_at' => $request->expired_at,
        ]);

        return Redirect::route('absenqr.index')->with('success', 'Absen Kode QR ' . $absenqr->jadwal->mapel->nama . 'Tanggal Absen' . $absenqr->tanggal->absen . ' berhasil di tambah.');
    }

    public function edit(Absen_Qr $absenQr)
    {
        $type_menu = 'absen';
        $jadwal = Jadwal::all();

        return view('pages.absenqr.edit', compact('absenqr', 'type_menu', 'jadwal'));

    }
    public function update(Request $request, Absen_Qr $absenQr)
    {
        $request->validate([
             'jadwal_id' => 'required',
            'tanggal_absen' => 'required|date',
            'token_qr' => 'required',
            'expired_at' => 'required',
        ]);

        $absenQr->update([
            'jadwal_id' => $request->jadwal_id,
            'tanggal_absen' => $request->tanggal_absen,
            'token_qr' => $request->token_qr,
            'expired_at' => $request->expired_at,
        ]);

        return Redirect::route('absenqr.index')->with('success', 'Absen Kode QR ' . $absenQr->jadwal->mapel->nama . 'Tanggal Absen' . $absenQr->tanggal->absen .' berhasil di ubah.');
    }
    public function destroy(Absen_Qr $absenQr)
    {
        $absenQr->delete();
        return Redirect::route('kelas.index')->with('success', 'Absen Kode QR ' . $absenQr->jadwal->mapel->nama . 'Tanggal Absen' . $absenQr->tanggal->absen . ' berhasil di hapus.');
    }
}
