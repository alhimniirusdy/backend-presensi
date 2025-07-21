<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'jadwal_id',
        'absen_qr_id',
        'waktu',
        'latitude',
        'longitude',
        'status',
    ];
}
