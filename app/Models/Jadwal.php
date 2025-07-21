<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];
}
