<?php

namespace App\Http\Controllers;

use App\Models\Absen_Qr;
use App\Models\Jadwal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class AbsenQrController extends Controller
{
    public function index()
    {
        $type_menu = 'absen';
        $absenqr = Absen_Qr::with('jadwal.mapel', 'jadwal.kelas')->latest()->paginate(10);
        return view('pages.absenqr.index', compact('absenqr', 'type_menu'));
    }

    public function create()
    {
        $type_menu = 'absen';
        // Optimasi query, hanya ambil kolom yang dibutuhkan
        $jadwal = Jadwal::select('id', 'nama_mapel', 'hari')->get(); // Ganti 'nama_mapel' sesuai nama kolom Anda

        return view('pages.absenqr.create', compact('type_menu', 'jadwal'));
    }

    protected function generateQRCodeToken()
    {
        do {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $code = substr(str_shuffle($characters), 0, 6);
        } while (Absen_Qr::where('token_qr', $code)->exists());

        return $code;
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal_absen' => 'required|date',
            'expired_at' => 'required|date|after:tanggal_absen',
        ]);

        $absenqr = Absen_Qr::create([
            'jadwal_id' => $request->jadwal_id,
            'tanggal_absen' => $request->tanggal_absen,
            'token_qr' => $this->generateQRCodeToken(),
            'expired_at' => $request->expired_at,
        ]);

        return redirect()->route('absenqr.index')->with('success', 'QR Token Berhasil di Buat untuk Tanggal Absen ' . $absenqr->tanggal_absen);
    }
    // public function update(Request $request, AbsenQr $absenqr)
    // {

    // }
    public function show($id)
    {
        $type_menu = 'absen';
        // 1. Cari data berdasarkan ID, jika tidak ada akan error 404
        $absenqr = Absen_Qr::with('jadwal.mapel', 'jadwal.kelas')->findOrFail($id);

        // 2. Kirim data tersebut ke file view
        return view('pages.absenqr.show', compact('absenqr', 'type_menu'));
    }

    public function displayQrCode($id)
    {
       
    }

    public function downloadPDF($id)
    {
        $qrAbsen = Absen_Qr::findOrFail($id);

       
        $data = [
            'qrAbsen' => $qrAbsen,
            'qrCodeBase64' => $qrCodeBase64, // Kirim base64 ke view PDF
        ];

        $pdf = Pdf::loadView('pages.pdf.qr_absen', $data);
        return $pdf->download('qr_absen_' . $qrAbsen->tanggal_absen . '.pdf');
    }
}
