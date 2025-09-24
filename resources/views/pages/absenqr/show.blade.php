@extends('layouts.app')

@section('title', 'QR Absen')

@php
    // Menggunakan Carbon untuk memformat tanggal
    use Carbon\Carbon;
@endphp

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>QR Absen</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    QR Absen untuk tanggal
                                    {{ Carbon::parse($absenqr->tanggal_absen)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                </h4>
                                {{-- Pastikan nama route untuk download PDF sudah benar --}}
                                {{-- <a href="{{ route('absenqr.downloadPDF', $absenqr->id) }}" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Download PDF
                                </a> --}}
                            </div>

                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 text-center">
                                        <h5>QR Check-in</h5>

                                        <div class="qr-code-container mb-3">
                                            {{--
                                                Ini adalah baris terpenting.
                                                Memanggil route 'absenqr.display_qr' untuk mendapatkan gambar QR.
                                            --}}
                                            <img src="{{ route('absenqr.display_qr', ['id' => $absenqr->id]) }}" alt="QR Code" style="max-width: 100%; height: auto;">
                                        </div>

                                        <p><strong>Kode Token:</strong> {{ $absenqr->token_qr }}</p>
                                        <p><strong>Mata Pelajaran:</strong> {{ $absenqr->jadwal->mapel->nama }}</p>
                                        <p><strong>Kelas:</strong> {{ $absenqr->jadwal->kelas->nama }}</p>
                                        <p><strong>Jam:</strong> {{ $absenqr->jadwal->jam_mulai }} - {{ $absenqr->jadwal->jam_selesai }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection