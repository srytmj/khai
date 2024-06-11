<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $fillable = [
        'kode_menu',
        'nama_menu',
        'harga_menu',
    ];

    public static function getKodeMenu()
    {
        // Implementasi kode untuk mendapatkan kode menu terakhir
                // query kode pegawai
        $sql = "SELECT IFNULL(MAX(menu), 'MNU-000') as menu 
                FROM pegawai";
        $menu = DB::select($sql);

        // cacah hasilnya
        foreach ($menu as $kdmnu) {
            $kd = $kdmnu->menu;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'mnu-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;
    }
}