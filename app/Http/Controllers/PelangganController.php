<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use Illuminate\Foundation\Http\FormRequest;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // untuk route tampilan
        //query data
        $pelanggan = Pelanggan::all();
        return view('pelanggan.view',
                    [
                        'pelanggan' => $pelanggan
                    ]
                  );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // berikan kode pelanggan secara otomatis
        // 1. query dulu ke db, select max untuk mengetahui posisi terakhir 
        
        return view('pelanggan/create',
                    [
                        'kode_pelanggan' => Pelanggan::getKodepelanggan()
                    ]
                  );
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru disimpan ke db
        $validated = $request->validate([
            'kode_pelanggan' => 'required',
            'nama_pelanggan' => 'required|unique:pelanggan|min:5|max:255',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        // masukkan ke db
        Pelanggan::create($request->all());
        
        return redirect()->route('pelanggan.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePelangganRequest  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        //digunakan untuk validasi kemudian kalau ok tidak ada masalah baru diupdate ke db
        $validated = $request->validate([
            'kode_pelanggan' => 'required',
            'nama_pelanggan' => 'required|max:255',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);
    
        $pelanggan->update($validated);
    
        return redirect()->route('pelanggan.index')->with('success','Data Pelanggan Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
   // public function destroy(pelanggan $pelanggan)
   public function destroy($id)
   {
       //hapus dari database
       $pelanggan = Pelanggan::findOrFail($id);
       $pelanggan->delete();

       return redirect()->route('pelanggan.index')->with('success','Data Berhasil di Hapus');
   }
}