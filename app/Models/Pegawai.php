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
    protected $fillable = ['kode_pegawai','nama_pegawai','jabatan','jenis_kelamin'];

    // query nilai max dari kode pegawai untuk generate otomatis kode pegawai
   static public function getKodepegawai()
    {
        // query kode pegawai
        $sql = "SELECT IFNULL(MAX(kode_pegawai), 'PL-000') as kode_pegawai 
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
        $noakhir = 'PL-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;

    }

    
}