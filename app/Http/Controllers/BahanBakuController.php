<?php

namespace App\Http\Controllers;

use App\Models\bahanbaku;
use App\Models\Supplier;

use Illuminate\Http\Request;

class bahanbakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //menampilkan data bahanbaku
    public function index()
    {
        //query data
        // $bahanbaku = Supplier::all();
        $bahanbaku = Supplier::join('bahan_baku', 'supplier.id', '=', 'bahan_baku.id')->get();
        return view('bahanbaku.view',
                    [
                        'bahanbaku' => $bahanbaku
                    ]
                  );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // berikan kode bahanbaku secara otomatis
        // 1. query dulu ke db, select max untuk mengetahui posisi terakhir 
        //mengambil dan mengembalikan data dari bd
        
        return view('bahanbaku/create',
                    [
                        'kode_bahanbaku' => bahanbaku::getKodebahanbaku()
                    ]
                  );

        return view('bahanbaku/view');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'kode_bahanbaku' => 'required|string|max:255|unique:bahan_baku,kode_bahanbaku',
            'nama_bahanbaku' => 'required|string|max:255',
            'satuan_bahanbaku' => 'required|string|max:255',
        ]);

        // Simpan data
        BahanBaku::create($validated);

        return redirect()->route('bahanbaku.index')->with('success', 'Bahan baku berhasil ditambahkan');
    }

    /**,.
     * Display the specified resource.
     */
    public function show(bahanbaku $bahanbaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bahanbaku $bahanbaku)
    {
        return view('/bahanbaku/edit', [
            'bahanbaku' => $bahanbaku
        ]);
        // return view('bahanbaku.edit', compact('bahanbaku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bahanbaku $bahanbaku)
    {
        $request->validate([
            'kode_bahanbaku' => 'required',
            'nama_bahanbaku' => 'required',
            'satuan_bahanbaku' => 'required',
        ]);
    
        $empData = [
            'kode_bahanbaku' => $request->input('kode_bahanbaku'),
            'nama_bahanbaku' => $request->input('nama_bahanbaku'),
            'satuan_bahanbaku' => $request->input('satuan_bahanbaku'),
        ];
    
        $bahanbaku->update($empData);
    
        return redirect()->route('bahanbaku.index')
                        ->with('success', 'Bahanbaku updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy ($id)
    {
         //hapus dari database
        $bahanbaku = bahanbaku::findOrFail($id);
        $bahanbaku->delete();

        return redirect()->route('bahanbaku.index')->with('success','Data Berhasil di Hapus');
    }
}