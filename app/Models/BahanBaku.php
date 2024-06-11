<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class BahanBaku extends Model
{
    use HasFactory;
    protected $table = 'bahan_baku';
    // list kolom yang bisa diisi

    protected $guarded = ['id'];

    protected $with = 'pembelian';

    // query nilai max dari kode perusahaan untuk generate otomatis kode perusahaan
    public static function getKodeBahanBaku()
    {
        // query kode perusahaan
        $sql = "SELECT IFNULL(MAX(kode_barang), 'BB-000') as kode_barang 
                FROM bahan_baku";
        $kode_barang = DB::select($sql);

        // cacah hasilnya
        foreach ($kode_barang as $kdbhnbk) {
            $kd = $kdbhnbk->kode_barang;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd, -3);
        $noakhir = $noawal + 1; //menambahkan 1, hasilnya adalah integer cth 1

        //menyambung dengan string PR-001
        $noakhir = 'BB-' . str_pad($noakhir, 3, "0", STR_PAD_LEFT);

        return $noakhir;
    }

    public function pembelian()
    {
        return $this->belongsTo(pembelian::class, 'kode_pembelian');
    }
}
