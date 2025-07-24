<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa_orangTua extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'orang_tua_id',
        'hubungan',
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function orangtua()
    {
        return $this->belongsTo(OrangTua::class);
    }
}
