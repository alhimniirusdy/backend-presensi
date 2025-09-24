@extends('layouts.user')

@section('title', 'Download Aplikasi')

@section('main')
<div class="container py-5">
    <div class="card shadow-sm mx-auto text-center" style="max-width: 600px;">
        <div class="card-header bg-primary">
            <h4 class="text-white mb-0">Download Aplikasi</h4>
        </div>
        <div class="card-body py-5">
            <p class="mb-4 text-muted">
                Klik tombol di bawah ini untuk mengunduh aplikasi resmi kami.
            </p>

            {{-- Tombol Download APK --}}
            <a href="{{ asset('apk/absensi_qr.apk') }}" class="btn btn-success btn-lg mb-3" download>
                <i class="fas fa-download"></i> Download untuk Android (.apk)
            </a>
        </div>
    </div>
</div>
@endsection
