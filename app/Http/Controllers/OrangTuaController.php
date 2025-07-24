<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrangTuaController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'siswa';

        $keyword = trim($request->input('search'));

        $orangtua = when($keyword, function ($query, $name) {
            $query->where('nama', 'like', '%' . $name . '%');
        })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $orangtua->appends([
            'search' => $keyword,
        ]);

        return view('pages.orang_tua.index', compact('type_menu', 'orangtua'));
    }
    public function create()
    {
        $type_menu = 'siswa';

        return view('pages.orang_tua.create', compact('type_menu'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required',
            'no_telepon' => 'required',
        ]);
        $orangtua = OrangTua::create([
            'nama' => $validatedData['nama'],
            'alamat' => $validatedData['alamat'],
            'pekerjaan' => $validatedData['pekerjaan'],
            'no_telepon' => $validatedData['no_telepon'],
        ]);
        return Redirect::route('orangtua.index')->with('success', $orangtua->nama . 'berhasil di tambah.');
    }
    public function edit(OrangTua $orangtua)
    {
        $type_menu = 'siswa';
        return view('pages.siswa.edit', compact('orangtua', 'type_menu'));
    }
    public function update(Request $request, OrangTua $orangTua)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required',
            'no_telepon' => 'required',
        ]);

        $orangTua->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan,
            'no_telepon' => $request->no_telepon,
        ]);
        return Redirect::route('orangtua.index')->with('success', $orangTua->nama . 'berhasil di ubah.');
    }
    public function destroy(OrangTua $orangTua)
    {
        $orangTua->delete();
        return Redirect::route('orangtua.index')->with('success', $orangTua->nama . 'berhasil di hapus.');
    }
}
