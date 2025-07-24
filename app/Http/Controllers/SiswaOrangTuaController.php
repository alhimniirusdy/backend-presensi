<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\Siswa_orangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SiswaOrangTuaController extends Controller
{
     public function index(Request $request)
    {
        $type_menu = 'siswa';

        $keyword = trim($request->input('search'));

        $siswa_ortu = Siswa_orangTua::with('siswa', 'orangtua')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('user', function ($q2) use ($keyword) {
                        $q2->where('name', 'like', '%' . $keyword . '%');
                    });
                });
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $siswa_ortu->appends([
            'search' => $keyword,
        ]);

        return view('pages.orang_tua.index', compact('type_menu', 'siswa_ortu'));
    }
    public function create()
    {
        $type_menu = 'siswa';
        $siswa = Siswa::all();
        $orang_tua = OrangTua::all();

        return view('pages.orang_tua.create', compact('type_menu', 'orang_tua', 'siswa'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'siswa_id' => 'required|unique:Siswa_orang_tuas,siswa_id',
            'orangtua_id' => 'required|unique:Siswa_orang_tuas,siswa_id',
            'hubungan' => 'required',
        ]);
        $siswa_ortu = Siswa_orangTua::create([
            'siswa_id' => $validatedData['siswa_id'],
            'orangtua_id' => $validatedData['orangtua_id'],
            'hubungan' => $validatedData['hubungan'],
        ]);
        return Redirect::route('ortu_siswa.index')->with('success',  'Siswa dengan Nama'. $siswa_ortu->siswa->user->name . 'dengan' .$siswa_ortu->hubungan . 'dengan Namma' .$siswa_ortu->ortu->nama. 'berhasil di tambah.');
    }
    public function edit(Siswa_orangTua $siswa_orangTua)
    {
        $type_menu = 'siswa';
        $siswa = Siswa::all();
        $orang_tua = OrangTua::all();

        return view('pages.orang_tua.edit', compact('siswa', 'type_menu', 'siswa', 'orang_tua'));
    }
    public function update(Request $request, Siswa_orangTua $siswa_orangTua)
    {
        $request->validate([
            'siswa_id' => 'required|unique:Siswa_orang_tuas,siswa_id',
            'orangtua_id' => 'required|unique:Siswa_orang_tuas,siswa_id',
            'hubungan' => 'required',
        ]);

        $siswa_orangTua->update([
            'siswa_id' => $request->siswa_id,
            'orangtua_id' => $request->orangtua_id,
            'hubungan' => $request->hubungan,
        ]);
        return Redirect::route('ortu_siswa.index')->with('success',  'Siswa dengan Nama'. $siswa_orangTua->siswa->user->name . 'dengan' .$siswa_orangTua->hubungan . 'dengan Nama' .$siswa_orangTua->ortu->nama. 'berhasil di ubah.');
    }
    public function destroy(Siswa_orangTua $siswa_orangTua)
    {
        $siswa_orangTua->delete();
        return Redirect::route('ortu_siswa.index')->with('success',  'Siswa dengan Nama'. $siswa_orangTua->siswa->user->name . 'dengan' .$siswa_orangTua->hubungan . 'dengan Nama' .$siswa_orangTua->ortu->nama. 'berhasil di hapus.');
    }
    public function show(Siswa_orangTua $siswa_orangTua)
    {
        $type_menu = 'siswa';
        return view('pages.ortu_siswa.show', compact('siswa_orangTua', 'type_menu'));
    }
}
