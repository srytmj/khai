<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Penjualan;

use Illuminate\Support\Facades\DB; // untuk query 
use Illuminate\Support\Facades\Auth; //untuk mendapatkan auth
use Illuminate\Support\Facades\Validator; //untuk validasi

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // // getViewBarang()
        $barang = Penjualan::getBarang();
        $id_customer = Auth::id();
        return view(
            'penjualan.view',
            [
                'barang' => $barang,
                'jml' => Penjualan::getJmlMenu($id_customer),
                'jml_invoice' => Penjualan::getJmlInvoice($id_customer),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePembayaranRequest $request)
    {
        $validated = $request->validate([
            'tgl_bayar' => 'required',
            'bukti_bayar' => 'file|required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validated) {
            // berhasil

            if ($request->input('tipeproses') == 'tunai') {

                $file = $request->file('bukti_bayar');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $tujuan_upload = 'konfirmasi';
                $file->move($tujuan_upload, $fileName);

                // simpan data
                $empData = ['no_transaksi' => $request->input('no_transaksi'), 'tgl_bayar' => $request->input('tgl_bayar'), 'bukti_bayar' => $fileName, 'jenis_pembayaran' => 'tunai', 'status' => 'menunggu_approve'];
                Pembayaran::create($empData);

                // update status menjadi konfirmasi bayar
                $id_customer = Auth::id();
                Pembayaran::updateStatusKonformasiPembayaran($request->input('no_transaksi'), $id_customer);

                return redirect('/pembayaran/viewstatus');
                // return redirect()->to('/pembayaran')->with('success','Data Konfirmasi Berhasil di Input');
            }
        } else {
            // validasi gagal
            //query data
            $id_customer = Auth::id();
            $keranjang = Penjualan::viewKeranjang($id_customer);
            return view(
                'pembayaran/create',
                [
                    'keranjang' => $keranjang
                ]
            );
        }
    }

    public function viewkeranjang()
    {
        //query data
        $id_customer = Auth::id();
        $keranjang = Penjualan::viewSiapBayar($id_customer);
        return view('pembayaran/create',
            [
                'keranjang' => $keranjang
            ]
        );
    }

    // view status pembayaran
    public function viewstatus()
    {
        //query data
        $id_customer = Auth::id();
        $pembayaran = Pembayaran::viewstatus($id_customer);
        return view('pembayaran.view',
            [
                'statuspembayaran' => $pembayaran
            ]
        );
    }

    // view status pembayaran
    public function viewstatusPG()
    {
        //query data
        $id_customer = Auth::id();
        $pembayaran = Pembayaran::viewstatusPG($id_customer);
        return view('pembayaran/viewpg',
            [
                'statuspembayaran' => $pembayaran
            ]
        );
    }

    // view status pembayaran
    public function viewstatusPGAll()
    {
        //query data
        $pembayaran = Pembayaran::viewstatusPGAll();
        return $pembayaran;
    }

    // view approval pembayaran
    public function viewapprovalstatus()
    {
        //query data
        $id_customer = Auth::id();
        $pembayaran = Pembayaran::viewstatusall();
        return view('pembayaran/viewapproval',
            [
                'statuspembayaran' => $pembayaran
            ]
        );
    }

    // proses approval pembayaran
    public function approve($no_transaksi)
    {
        // echo $no_transaksi;
        // update status di tabel pembayaran
        $date = date('Y-m-d H:i:s');

        $affected = DB::table('pembayaran')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'status' => 'approved',
                'tgl_konfirmasi' => $date
            ]);

        // update di tabel penjualan statusnya sudah selesai
        $affected = DB::table('penjualan')
            ->where('no_transaksi', $no_transaksi)
            ->update([
                'status' => 'selesai'
            ]);

        // tambahkan ke status transaksi
        $id_customer = Auth::id();
        DB::table('status_transaksi')->insert([
            'no_transaksi' => $no_transaksi,
            'id_customer' => $id_customer,
            'status' => 'approved',
            'waktu' => now(),
        ]);

        // query dapatkan nilai nominal transaksi
        $data_penjualan = DB::table('penjualan')->where('no_transaksi', $no_transaksi)->first();
        $data_pembayaran = DB::table('pembayaran')->where('no_transaksi', $no_transaksi)->first();

        //catat ke jurnal
        DB::table('jurnal')->insert([
            'id_transaksi' => $data_pembayaran->id,
            'id_perusahaan' => 1, //bisa diganti kalau sudah live
            'kode_akun' => '111',
            'tgl_jurnal' => $date,
            'posisi_d_c' => 'd',
            'nominal' => $data_penjualan->total_harga,
            'kelompok' => 1,
            'transaksi' => 'penjualan',
        ]);

        DB::table('jurnal')->insert([
            'id_transaksi' => $data_pembayaran->id,
            'id_perusahaan' => 1, //bisa diganti kalau sudah live
            'kode_akun' => '411',
            'tgl_jurnal' => $date,
            'posisi_d_c' => 'c',
            'nominal' => $data_penjualan->total_harga,
            'kelompok' => 1,
            'transaksi' => 'penjualan',
        ]);

        return redirect('/pembayaran/   viewapprovalstatus')->with('success', 'Approve sukses');
    }
}