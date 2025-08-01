<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'kode',
        'guru_id',
    ];
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
