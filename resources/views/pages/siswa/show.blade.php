@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Siswa</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Siswa</h4>
                    </div>

                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">Nama User</dt>
                            <dd class="col-sm-9">{{ $siswa->user->name }}</dd>

                            <dt class="col-sm-3">Email</dt>
                            <dd class="col-sm-9">{{ $siswa->user->email }}</dd>

                            <dt class="col-sm-3">Kelas</dt>
                            <dd class="col-sm-9">{{ $siswa->kelas->nama }}</dd>

                            <dt class="col-sm-3">NIS</dt>
                            <dd class="col-sm-9">{{ $siswa->nis }}</dd>

                            <dt class="col-sm-3">NISN</dt>
                            <dd class="col-sm-9">{{ $siswa->nisn }}</dd>

                            <dt class="col-sm-3">Jenis Kelamin</dt>
                            <dd class="col-sm-9">{{ $siswa->jenis_kelamin }}</dd>

                            <dt class="col-sm-3">No Telepon</dt>
                            <dd class="col-sm-9">{{ $siswa->no_telepon }}</dd>

                            <dt class="col-sm-3">Dibuat Pada</dt>
                            <dd class="col-sm-9">{{ $siswa->created_at->format('d-m-Y H:i') }}</dd>

                            <dt class="col-sm-3">Diubah Pada</dt>
                            <dd class="col-sm-9">{{ $siswa->updated_at->format('d-m-Y H:i') }}</dd>
                        </dl>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('siswa.index') }}" class="btn btn-warning">Kembali</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
