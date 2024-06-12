<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// jika ingin menggunakan query biasa
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = ['no_transaksi','id_customer','tgl_transaksi','tgl_expired','total_harga','status'];

    // untuk melihat data menu
    public static function getMenu()
    {
        // query ke tabel menu
        $sql = "SELECT * FROM menu";
        $menu = DB::select($sql);
        return $menu;
    }

    // untuk melihat data menu berdasarkan id
    public static function getMenuId($id)
    {
        $sql = "SELECT * FROM menu WHERE id = ?";
        $menu = DB::select($sql,[$id]);
        return $menu;
    }

    // untuk melihat data invoice
    public static function getListInvoice($id_customer)
    {
        $penjualan = Penjualan::where('id_customer', $id_customer)
                                ->where('status', 'siap_bayar')
                                ->get();
        return $penjualan;
    }

    // cekout
    public static function checkout($id_customer)
    {

        // dapatkan nomor transaksinya
        $sql = "SELECT max(no_transaksi) as mak_no_transaksi
                FROM penjualan WHERE id_customer = ? AND status = 'pesan'";
        $penjualan = DB::select($sql,[$id_customer]);
        foreach($penjualan as $b):
            $no_transaksi = $b->mak_no_transaksi;
        endforeach;

        // update status menjadi siap bayar
        $affected = DB::table('penjualan')
                    ->where('no_transaksi', $no_transaksi)
                    ->update(['status' => 'siap_bayar']);

        // simpan status transaksi
        // tambahkan ke status transaksi
        DB::table('status_transaksi')->insert([
            'no_transaksi' => $no_transaksi,
            'id_customer' => $id_customer,
            'status' => 'siap_bayar',
            'waktu' => now(),
        ]);
    }

    // lihat stok menu
    public static function getStock($id){
        $sql = "SELECT stok FROM menu WHERE id = ?";
        $menu = DB::select($sql,[$id]);
        foreach($menu as $b):
            $stok = $b->stok;
        endforeach;
        return $stok;
    }

    // lihat id ke berapa status pemesanan si customer
    public static function getIdStatus($id_customer){
        $sql = "SELECT ifnull(max(a.id),0) as id
                FROM status_pemesanan a
                JOIN (
                     SELECT status FROM penjualan
                     WHERE id_customer = ?
                     AND no_transaksi = (
                        SELECT max(no_transaksi)
                        FROM penjualan WHERE id_customer = ?
                        )
                    UNION
                     SELECT status FROM pembayaran
                     WHERE no_transaksi = (
                        SELECT max(no_transaksi)
                        FROM penjualan WHERE id_customer = ?
                        )
                ) b ON (a.status=b.status)
                ";
        $status_pemesanan = DB::select($sql,[$id_customer,$id_customer,$id_customer]);
        foreach($status_pemesanan as $b):
            $id = $b->id;
        endforeach;
        return $id;
    }

    // lihat status pemesanan berdasarkan id customer
    public static function getStatusAll($id_customer){

        $sql = "SELECT a.*,b.status as status_customer,b.waktu as tgl_transaksi
                FROM status_pemesanan a LEFT OUTER JOIN
                ( SELECT * FROM status_transaksi WHERE id_customer = ?
                  AND no_transaksi = ( SELECT max(no_transaksi) FROM penjualan
                  WHERE id_customer = ? ) ) b ON (a.status=b.status) ORDER BY a.id";
        $status_pemesanan = DB::select($sql,[$id_customer,$id_customer]);
        return $status_pemesanan;
    }

    public static function tes(){
        $penjualan = new Penjualan;
        $faktur = $penjualan->getInvoiceNumber();
        return $faktur;
    }

    // dapatkan nomor faktur yang baru
    public static function getInvoiceNumber(){
        $sql = "SELECT SUBSTRING(IFNULL(MAX(no_transaksi),'FK-0000'),4)+0 AS no
                FROM penjualan";
        $menu = DB::select($sql);
        foreach($menu as $b):
            $urutan = $b->no;
        endforeach;

        // pembentukan nomor faktur
        $urutan = $urutan + 1;
        $str = (string)$urutan;
        //menambahkan 0 di samping kiri angka
        $no  = str_pad($str,4,"0",STR_PAD_LEFT);
        $faktur = 'FK-'.$no;
        return $faktur;
    }

    // prosedur input data penjualan
    public static function inputPenjualan($id_customer,$total_harga,$id,$jml_barang,$harga_menu,$total){

        // instansiasi obyek
        $penjualan = new Penjualan;
        // query apakah ada di keranjang
        // query kode perusahaan
        $sql = "SELECT COUNT(*) as jml
                FROM penjualan
                WHERE id_customer = ?
                AND status not in ('expired','selesai','siap_bayar','konfirmasi_bayar')";
        $menu = DB::select($sql,[$id_customer]);
        foreach($menu as $b):
            $jml = $b->jml;
        endforeach;

        // jika jumlahnya 0 maka buat nomor transaksi baru
        // ['no_transaksi','id_customer','tgl_transaksi','tgl_expired','total_harga','status'];
        if($jml==0){

            // dapatkan nomor faktur terakhir cth format FK-0004
            $faktur = $penjualan->getInvoiceNumber();

            // masukkan ke tabel induk dulu yaitu di tabel penjualan
            // baru ke tabel anaknya penjualan_detail

            $date = date('Y-m-d H:i:s');
            //tambahkan 3 hari untuk expired datenya dari tanggal sekarang
            $date_plus_3=Date('Y-m-d H:i:s', strtotime('+3 days'));
            DB::table('penjualan')->insert([
                'no_transaksi' => $faktur,
                'id_customer' => $id_customer,
                'tgl_transaksi' => $date,
                'tgl_expired' => $date_plus_3,
                'total_harga' => $total_harga,
                'status' => 'pesan' //isinya 'pesan','expired','selesai','siap_bayar','konfirmasi_bayar'
            ]);

            // masukkan ke tabel detail_penjualan
            DB::table('penjualan_detail')->insert([
                'no_transaksi' => $faktur,
                'id' => $id,
                'harga_menu' => $harga_menu,
                'jml_barang' => $jml_barang,
                'total' => $total,
                'tgl_transaksi' => $date,
                'tgl_expired' => $date_plus_3
            ]);

            // update stok di tabel barang menjadi berkurang
            // dapatkan stok dulu
            $penjualan = new Penjualan;
            $stok = $penjualan->getStock($id);
            $stok_akhir = $stok - $jml_barang;
            $affected = DB::table('menu')
              ->where('id', $id)
              ->update(['stok' => $stok_akhir]);

            // tambahkan ke status transaksi
            DB::table('status_transaksi')->insert([
                'no_transaksi' => $faktur,
                'id_customer' => $id_customer,
                'status' => 'pesan',
                'waktu' => now(),
            ]);

        }else{
            // jika sudah ada nomor fakturnya
            // 1. update transaksi yang masih menggantung ke expired jika di tabel detail sudah expired semua
            //    dapatkan max tgl expired
            $sql = "SELECT no_transaksi,MAX(tgl_expired) as mak_expired
                    FROM penjualan_detail WHERE
                    no_transaksi IN
                    (
                        SELECT no_transaksi
                        FROM penjualan
                        WHERE id_customer = ?
                        AND status NOT IN ('selesai','expired','siap_bayar','konfirmasi_bayar')
                    )
                    GROUP BY no_transaksi
                   ";
            $menu = DB::select($sql,[$id_customer]);
            foreach($menu as $b):
                $mak_expired = $b->mak_expired;
                $no_transaksi = $b->no_transaksi;
            endforeach;

            // update ke tabel transaksi expirednya menjadi expired terlama dari detail penjualan
            $affected = DB::table('penjualan')
              ->where('no_transaksi', $no_transaksi)
              ->update(['tgl_expired' => $mak_expired]);

            // jika mak expired sudah melewati masa sekarang
            // maka lakukan update status pesanan menjadi 'expired'
            $date = date('Y-m-d H:i:s');
            if($date>$mak_expired){
                // update status menjadi expired
                    $affected = DB::table('penjualan')
                ->where('no_transaksi', $no_transaksi)
                ->update(['status' => 'expired']);

                // kembalikan stok
                $sql = "SELECT id,jml_barang
                        FROM penjualan_detail
                        WHERE  no_transaksi = ?
                    ";
                $menu = DB::select($sql,[$no_transaksi]);
                foreach($menu as $b):
                    $id = $b->id;
                    $jml_barang_lama = $b->jml_barang;
                    // query stok
                    // kembalikan stok
                    $stok = $penjualan->getStock($id);
                    $stok_akhir = $stok + $jml_barang_lama;
                    $affected = DB::table('menu')
                    ->where('id', $id)
                    ->update(['stok' => $stok_akhir]);
                endforeach;

                // buat nomor faktur baru dan masukkan ke tabel
                // dapatkan nomor faktur terakhir cth format FK-0004
                $faktur = $penjualan->getInvoiceNumber();

                // tambahkan ke status transaksi
                DB::table('status_transaksi')->insert([
                    'no_transaksi' => $no_transaksi,
                    'id_customer' => $id_customer,
                    'status' => 'expired',
                    'waktu' => now(),
                ]);

                // masukkan ke tabel induk dulu yaitu di tabel penjualan

                $date = date('Y-m-d H:i:s');
                $date_plus_3=Date('Y-m-d H:i:s', strtotime('+3 days')); //tambahkan 3 hari untuk expired datenya
                DB::table('penjualan')->insert([
                    'no_transaksi' => $faktur,
                    'id_customer' => $id_customer,
                    'tgl_transaksi' => $date,
                    'tgl_expired' => $date_plus_3,
                    'total_harga' => $total_harga,
                    'status' => 'pesan' //isinya pesan, selesai, expired
                ]);

                // masukkan ke tabel detail_penjualan
                DB::table('penjualan_detail')->insert([
                    'no_transaksi' => $faktur,
                    'id' => $id,
                    'harga_menu' => $harga_menu,
                    'jml_barang' => $jml_barang,
                    'total' => $total,
                    'tgl_transaksi' => $date,
                    'tgl_expired' => $date_plus_3
                ]);

                // update stok di tabel barang menjadi berkurang
                // dapatkan stok dulu
                $stok = $penjualan->getStock($id);
                $stok_akhir = $stok - $jml_barang;
                $affected = DB::table('menu')
                ->where('id', $id)
                ->update(['stok' => $stok_akhir]);
                // akhir buat nomor faktur baru

                // tambahkan ke status transaksi
                DB::table('status_transaksi')->insert([
                    'no_transaksi' => $faktur,
                    'id_customer' => $id_customer,
                    'status' => 'pesan',
                    'waktu' => now(),
                ]);

            }else{
                // belum mencapai masa expired, maka
                // tambahkan total belanja ke tabel penjualan_detail
                // cek untuk id barang yang sama, maka tidak usah tambah lagi,
                // tapi cukup jml belanjanya diupdate
                // selain itu masukkan lagi ke penjualan detail
                // 1. cek apakah yg diinputkan adalah id barang yang sudah ada di keranjang atau tidak
                $sql = "SELECT id,jml_barang,no_transaksi FROM penjualan_detail
                        WHERE
                        no_transaksi IN
                        (
                            SELECT no_transaksi
                            FROM penjualan
                            WHERE id_customer = ? AND status NOT IN ('selesai','expired','siap_bayar','konfirmasi_bayar')
                        ) AND id = ?
                        ";
                $menu = DB::select($sql,[$id_customer,$id]);
                $cek = 0;
                foreach($menu as $b):
                    $id_tabel = $b->id;
                    $jml_barang_tabel = $b->jml_barang;
                    $no_transaksi_tabel = $b->no_transaksi;
                    $cek = 1;
                    // tambahkan jml barangnya dan tamnbahkan masa expirednya
                    $date_plus_3=Date('Y-m-d H:i:s', strtotime('+3 days')); //tambahkan 3 hari untuk expired datenya
                    $jml_barang_akhir = $jml_barang + $jml_barang_tabel;
                    $total_tagihan  = $harga_menu * $jml_barang_akhir;
                    $affected = DB::table('penjualan_detail')
                    ->where('no_transaksi','=', $no_transaksi_tabel)
                    ->where('id', '=',$id_tabel)
                    ->update(['jml_barang' => $jml_barang_akhir,'total'=> $total_tagihan,
                              'tgl_transaksi' => $date_plus_3
                             ]);

                    // dapatkan stok dulu
                    $stok = $penjualan->getStock($id);
                    $stok_akhir = $stok - $jml_barang;
                    $affected = DB::table('menu')
                    ->where('id', $id)
                    ->update(['stok' => $stok_akhir]);

                endforeach;

                // jika nilai variabel cek == 0 maka ini adalah inputan baru
                if($cek==0){
                    //
                    // buat nomor faktur baru dan masukkan ke tabel
                    // dapatkan nomor faktur terakhir cth format FK-0004
                    $sql = "SELECT max(no_transaksi) as no_transaksi  FROM penjualan
                            WHERE id_customer = ? AND status NOT IN ('selesai','expired','siap_bayar','konfirmasi_bayar')
                           ";
                    $menu = DB::select($sql,[$id_customer]);
                    foreach($menu as $b):
                        $no_transaksi = $b->no_transaksi;
                    endforeach;

                    $sql = "SELECT total_harga  FROM penjualan
                            WHERE no_transaksi = ?
                           ";
                    $menu = DB::select($sql,[$no_transaksi]);
                    foreach($menu as $b):
                        $total_harga_lama = $b->total_harga;
                    endforeach;

                    // $total_harga_lama = $b->total_harga;
                    // masukkan ke tabel induk dulu yaitu di tabel penjualan
                    $total_harga_baru = $total_harga+$total_harga_lama;
                    $date = date('Y-m-d H:i:s');
                    $date_plus_3=Date('Y-m-d H:i:s', strtotime('+3 days')); //tambahkan 3 hari untuk expired datenya
                    // update total harga di penjualan karena sudah ditambah item baru
                    $affected = DB::table('penjualan')
                    ->where('no_transaksi', $no_transaksi)
                    ->update(
                                [   'tgl_expired' => $date_plus_3,
                                    'total_harga'=> $total_harga_baru,
                                ]
                            );

                    // masukkan ke tabel detail_penjualan
                    DB::table('penjualan_detail')->insert([
                        'no_transaksi' => $no_transaksi,
                        'id' => $id,
                        'harga_menu' => $harga_menu,
                        'jml_barang' => $jml_barang,
                        'total' => $total,
                        'tgl_transaksi' => $date,
                        'tgl_expired' => $date_plus_3
                    ]);

                    // update stok di tabel barang menjadi berkurang
                    // dapatkan stok dulu
                    $stok = $penjualan->getStock($id);
                    $stok_akhir = $stok - $jml_barang;
                    $affected = DB::table('menu')
                    ->where('id', $id)
                    ->update(['stok' => $stok_akhir]);
                    // akhir buat nomor faktur baru
                    //
                }
            }
        }

    }

    // view keranjang belanja
    public static function viewKeranjang($id_customer){
        $sql = "SELECT  a.no_transaksi,
                        c.nama_menu,
                        c.harga_menu,
                        b.tgl_transaksi,
                        b.tgl_expired,
                        b.jml_barang,
                        b.total,
                        a.status,
                        b.id as id_penjualan_detail
                FROM penjualan a
                JOIN penjualan_detail b
                ON (a.no_transaksi=b.no_transaksi)
                JOIN menu c
                ON (b.id = c.id)
                WHERE a.id_customer = ? AND a.status
                not in ('selesai','expired','siap_bayar','konfirmasi_bayar')";
        $menu = DB::select($sql,[$id_customer]);
        return $menu;
    }

    // view data siap bayar
    // view keranjang belanja
    public static function viewSiapBayar($id_customer){
        $sql = "SELECT  a.no_transaksi,
                        c.nama_menu,
                        c.harga_menu,
                        b.tgl_transaksi,
                        b.tgl_expired,
                        b.jml_barang,
                        b.total,
                        a.status,
                        b.id as id_penjualan_detail,
                        a.id as id_penjualan
                FROM penjualan a
                JOIN penjualan_detail b
                ON (a.no_transaksi=b.no_transaksi)
                JOIN menu c
                ON (b.id = c.id)
                WHERE a.id_customer = ? AND a.status
                in ('siap_bayar')";
        $menu = DB::select($sql,[$id_customer]);
        return $menu;
    }

    public static function jmlviewSiapBayar($id_customer){
        $sql = "SELECT  count(*) as jml
                FROM penjualan a
                JOIN penjualan_detail b
                ON (a.no_transaksi=b.no_transaksi)
                JOIN menu c
                ON (b.id = c.id)
                WHERE a.id_customer = ? AND a.status
                in ('siap_bayar')";
        $menu = DB::select($sql,[$id_customer]);
        return $menu;
    }

    // untuk menghapus data penjualan detail
    public static function hapuspenjualandetail($id_penjualan_detail){
        // dapatkan nomor transaksi dulu
        $sql = "SELECT  no_transaksi
                FROM penjualan_detail
                WHERE id = ? ";
        $transaksi = DB::select($sql,[$id_penjualan_detail]);
        foreach($transaksi as $b):
            $no = $b->no_transaksi;
        endforeach;

        // hapus datanya
        $sql = "DELETE FROM penjualan_detail WHERE id = ?";
        $nrd = DB::delete($sql,[$id_penjualan_detail]);


        // hitung total harga dari jml di penjualan detail
        $sql = "SELECT  SUM(total) as ttl
                FROM penjualan_detail
                WHERE no_transaksi = ? ";
        $total = DB::select($sql,[$no]);
        foreach($total as $b):
            $ttl = $b->ttl;
        endforeach;

        // update total harga di tabel penjualan
        $affected = DB::table('penjualan')
          ->where('no_transaksi', $no)
          ->update(['total_harga' => $ttl]);
    }

    // kembalikan stok
    public static function kembalikanstok($id_penjualan_detail){
        $penjualan = new Penjualan;
        $sql = "SELECT jml_barang,id FROM penjualan_detail WHERE id = ?";
        $menu = DB::select($sql,[$id_penjualan_detail]);
        foreach($menu as $b):
            $jml_barang = $b->jml_barang;
            $id = $b->id;
        endforeach;

        $stok = $penjualan->getStock($id);
        $stok_akhir = $stok + $jml_barang;
        $affected = DB::table('menu')
          ->where('id', $id)
          ->update(['stok' => $stok_akhir]);
    }

    // dapatkan jumlah barang
    public static function getJmlMenu($id_customer){
        $sql = "SELECT count(*) as jml FROM penjualan_detail
                WHERE no_transaksi IN
                (SELECT no_transaksi FROM penjualan
                 WHERE id_customer = ? AND status
                 NOT IN ('expired','hapus','siap_bayar','konfirmasi_bayar','selesai')
                )";
        $barang = DB::select($sql,[$id_customer]);
        foreach($barang as $b):
            $jml = $b->jml;
        endforeach;
        return $jml;
    }

    public static function getJmlInvoice($id_customer){
        $sql = "SELECT count(*) as jml FROM penjualan
                WHERE status = 'siap_bayar' AND id_customer = ?";
        $barang = DB::select($sql,[$id_customer]);
        foreach($barang as $b):
            $jml = $b->jml;
        endforeach;
        return $jml;
    }


}