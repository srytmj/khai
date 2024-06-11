<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;

    protected $table = 'coa';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'header_akun',
    ];

    public static function getKodeCoa()
    {
        // Implementasi kode untuk mendapatkan kode akun terakhir
    }
}