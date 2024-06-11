<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Http\Requests\StoreCoaRequest;
use App\Http\Requests\UpdateCoaRequest;

use Illuminate\Foundation\Http\FormRequest;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //query data
        $coa = Coa::all();
        return view('coa.view',
                    [
                        'coa' => $coa
                    ]
                  );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // berikan kode Coa secara otomatis
        // 1. query dulu ke db, select max untuk mengetahui posisi terakhir 
        
        return view('coa/create',
                    [
                        'kode_akun' => Coa::getKodeCoa()
                    ]
                  );
        // return view('Coa/view');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCoaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoaRequest $request)
    {
        // Validation rules with modified kode_akun
        $validated = $request->validate([
            'kode_akun' => 'required|max:4',
            'nama_akun' => 'required|max:255',
            'header_akun' => 'required',
        ]);
    
        
        // masukkan ke db
        Coa::create($validated);
        
        return redirect()->route('coa.index')->with('success','Data Berhasil di Input');
    }    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function show(Coa $coa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function edit(Coa $coa)
    {
        return view('coa.edit', compact('coa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCoaRequest  $request
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoaRequest $request, Coa $coa)
    {
        // Validation rules with modified kode_akun
        $validated = $request->validate([
            'kode_akun' => 'required|max:4',
            'nama_akun' => 'required|max:255',
            'header_akun' => 'required',
        ]);
    
               $coa->update($validated);
    
        return redirect()->route('coa.index')->with('success','Data Berhasil di Ubah');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Coa $coa)
    public function destroy($id)
    {
        // Hapus data muzakki berdasarkan ID
        $coa = Coa::findOrFail($id);
        $coa->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('coa.index')
            ->with('success', 'Data Coa berhasil dihapus.');
    }
}
