<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('/pegawai/view', [
            'pegawai' => Pegawai::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/pegawai/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $masuk = $request->validate([
            'kode_pegawai' => 'required',
            'nama_pegawai' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        Pegawai::create($masuk);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('/pegawai/edit', [
            'pegawai' => $pegawai
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $masuk = $request->validate([
            'kode_pegawai' => 'required',
            'nama_pegawai' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required'
        ]);
        
        Pegawai::where('id', $pegawai->id)
        ->update($masuk);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        Pegawai::destroy('id', $pegawai->id);

        return redirect('/');
    }
}