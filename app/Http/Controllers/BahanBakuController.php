<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreBahanBakuRequest;
use App\Http\Requests\UpdateBahanBakuRequest;


class BahanBakuController extends Controller
{
    /**
     */
    public function index()
    {
        //query data
        
        return view('bahanbaku/view', [
            'bb' => BahanBaku::with('pembelian')->get()
        ]);
    }

    /**
     */
    public function create()
    {
        // berikan kode perusahaan secara otomatis
        // 1. query dulu ke db, select max untuk mengetahui posisi terakhir 
        
        return view('/bahanbaku/create',
        [
            'kode_bahan_baku' => BahanBaku::getKodeBahanBaku(),
            'pembelian' => BahanBaku::with('pembelian')->get()
        ]
        );
        // return view('bahanbaku/view');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_bahan_baku' => 'required',
            'nama_bahan_baku' => 'required',
            'stock_bahan_baku' => 'required',
        ]);

        // masukkan ke db
        BahanBaku::create($validated);
        
        return redirect('/bahanbaku');
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(BahanBaku $bahanbaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(BahanBaku $bahanbaku)
    {
        return view('bahanbaku/edit', [
            'bahanbaku' => $bahanbaku
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, BahanBaku $bahanbaku)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru diupdate ke db
        $validated = $request->validate([
            'kode_bahan_baku' => 'required',
            'nama_bahan_baku' => 'required',
            'stock_bahan_baku' => 'required',
        ]);
    
        $bahanbaku->update($validated);
    
        return redirect('/bahanbaku');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    // public function destroy(Perusahaan $perusahaan)
    public function destroy($id)
    {
        //hapus dari database
        BahanBaku::destroy('id', $id);

        return redirect('/bahanbaku');
    }
}