<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'siswa';

        $keyword = trim($request->input('search'));
        $kelasId = $request->input('kelas'); // kelas yang dipilih

        $query = Siswa::with(['user', 'kelas']);

        if ($keyword) {
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $siswas = $query->latest()->paginate(10);
        $siswas->appends($request->only(['search', 'kelas']));

        $listKelas = Kelas::all();

        return view('pages.siswa.index', [
            'type_menu' => $type_menu,
            'siswas' => $siswas,
            'listKelas' => $listKelas,
            'kelasId' => $kelasId,
            'keyword' => $keyword
        ]);
    }
    public function create()
    {
        $type_menu = 'siswa';
        $listKelas = Kelas::all();
        $listUser = User::where('role', 'Siswa')->get();

        return view('pages.siswa.create', [
            'type_menu' => $type_menu,
            'listKelas' => $listKelas,
            'listUser' => $listUser
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|unique:siswas,user_id',
            'kelas_id' => 'required',
            'nis' => 'required',
            'nisn' => 'required',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required',
        ]);

        $siswa = Siswa::create($validatedData);

        return redirect()->route('siswa.index')->with('success', $siswa->user->name . ' berhasil ditambah.');

    }

    public function edit(Siswa $siswa)
    {
        $type_menu = 'siswa';
        $listKelas = Kelas::all();
        $listUser = User::where('role', 'Siswa')->get();

        return view('pages.siswa.edit', [
            'type_menu' => $type_menu,
            'siswa' => $siswa,
            'listKelas' => $listKelas,
            'listUser' => $listUser,
        ]);
    }
    public function update(Request $request, Siswa $siswa)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|unique:siswas,user_id,' . $siswa->id,
            'kelas_id' => 'required',
            'nis' => 'required',
            'nisn' => 'required',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'required',
        ]);

        $siswa->update($validatedData);

        return redirect()->route('siswa.index')->with('success', $siswa->user->name . ' berhasil diubah.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return Redirect::route('user.index')->with('success', $siswa->user->name . 'berhasil di hapus.');
    }
    public function show(Siswa $siswa)
    {
        $type_menu = 'siswa';
        return view('pages.siswa.show', compact('siswa', 'type_menu'));
    }

}
