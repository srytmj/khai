<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;

// untuk validator
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth; //untuk mendapatkan auth

class PenjualanController extends Controller
{
    public function index()
    {
        // getViewMenu()
        $menu = Penjualan::getMenu();
        $id_customer = Auth::id(); //dapatkan id customer dari sesi user
        return view('penjualan.view',
                [
                    'menu' => $menu,
                    'jml' => Penjualan::getJmlMenu($id_customer),
                    'jml_invoice' => Penjualan::getJmlInvoice($id_customer),
                ]
        );
    }

    // dapatkan data menu berdasarkan id menu
    public function getDataMenu($id){
        $menu = Penjualan::getMenuId($id);
        if($menu)
        {
            return response()->json([
                'status'=>200,
                'menu'=> $menu,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // dapatkan data menu berdasarkan id menu
    public function getDataMenuAll(){
        $barang = Penjualan::getMenu();
        if($barang)
        {
            return response()->json([
                'status'=>200,
                'barang'=> $barang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // dapatkan jumlah barang untuk keranjang
    public function getJumlahMenu(){
        $id_customer = Auth::id();
        $jml_barang = Penjualan::getJmlMenu($id_customer);
        if($jml_barang)
        {
            return response()->json([
                'status'=>200,
                'jumlah'=> $jml_barang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // dapatkan jumlah barang untuk keranjang
    public function getInvoice(){
        $id_customer = Auth::id();
        $jml_barang = Penjualan::getJmlInvoice($id_customer);
        if($jml_barang)
        {
            return response()->json([
                'status'=>200,
                'jmlinvoice'=> $jml_barang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

   
    public function create()
    {
        //
    }

    
    public function store(StorePenjualanRequest $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validator = Validator::make(
            $request->all(),
            [
                'jumlah' => 'required',
            ]
        );
        
        if($validator->fails()){
            // gagal
            return response()->json(
                [
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]
            );
        }else{
            // berhasil

            // cek apakah tipenya input atau update
            // input => tipeproses isinya adalah tambah
            // update => tipeproses isinya adalah ubah
            
            if($request->input('tipeproses')=='tambah'){

                $id_customer = Auth::id();
                $jml_barang = $request->input('jumlah');
                $id_menu = $request->input('idmenuhidden');

                $brg = Penjualan::getMenuId($id_menu);
                foreach($brg as $b):
                    $harga_menu = $b->harga_menu;
                endforeach;

                $total_harga = $harga_menu*$jml_barang;
                Penjualan::inputPenjualan($id_customer,$total_harga,$id_menu,$jml_barang,$harga_menu,$total_harga);

                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Sukses Input Data',
                    ]
                );
            }
        }
    }

    
    public function show(Penjualan $penjualan)
    {
        //
    }

    public function edit(Penjualan $penjualan)
    {
        //
    }

    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
        //
    }

    
    public function destroy(Penjualan $penjualan)
    {
        //
    }

    // view keranjang
    public function keranjang(){
        $id_customer = Auth::id();
        $keranjang = Penjualan::viewKeranjang($id_customer);
        return view('penjualan/viewkeranjang',
                [
                    'keranjang' => $keranjang
                ]
        );
    }

    // view status
    public function viewstatus(){
        $id_customer = Auth::id();
        // dapatkan id ke berapa dari status pemesanan
        $id_status_pemesanan = Penjualan::getIdStatus($id_customer);
        $status_pemesanan = Penjualan::getStatusAll($id_customer);
        return view('penjualan.viewstatus',
                [
                    'status_pemesanan' => $status_pemesanan,
                    'id_status_pemesanan'=> $id_status_pemesanan
                ]
        );
    } 

    // view keranjang
    public function keranjangjson(){
        $id_customer = Auth::id();
        $keranjang = Penjualan::viewKeranjang($id_customer);
        if($keranjang)
        {
            return response()->json([
                'status'=>200,
                'keranjang'=> $keranjang,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // view keranjang
    public function checkout(){
        $id_customer = Auth::id();
        Penjualan::checkout($id_customer); //proses cekout
        $barang = Penjualan::getMenu();

        return redirect('midtrans/bayar');
    }

    // invoice
    public function invoice(){
        $id_customer = Auth::id();
        $invoice = Penjualan::getListInvoice($id_customer);
        if($invoice)
        {
            return response()->json([
                'status'=>200,
                'invoice'=> $invoice,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Tidak ada data ditemukan.'
            ]);
        }
    }

    // delete penjualan detail
    public function destroypenjualandetail($id_penjualan_detail){
        // kembalikan stok ke semula
        Penjualan::kembalikanstok($id_penjualan_detail);

        //hapus dari database
        Penjualan::hapuspenjualandetail($id_penjualan_detail);

        $id_customer = Auth::id();
        $keranjang = Penjualan::viewKeranjang($id_customer);

        return view('penjualan/viewkeranjang',
            [
                'keranjang' => $keranjang,
                'status_hapus' => 'Sukses Hapus'
            ]
        );
    }
}