<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    // list kolom yang bisa diisi

    protected $fillable = ['kode_pegawai','nama_pegawai','alamat','jabatan','no_hp','jenis_kelamin','user_id','email', 'password'];

    // query nilai max dari kode pegawai untuk generate otomatis kode pegawai
    public static function getKodepegawai()
    {
        // query kode pegawai
        $sql = "SELECT IFNULL(MAX(kode_pegawai), 'PGW-000') as kode_pegawai 
                FROM pegawai";
        $kodepegawai = DB::select($sql);

        // cacah hasilnya
        foreach ($kodepegawai as $kdpgw) {
            $kd = $kdpgw->kode_pegawai;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'PGW-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}