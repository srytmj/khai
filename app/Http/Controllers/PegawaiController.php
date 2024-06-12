<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use Illuminate\Support\Facades\DB;

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
        return view('pegawai/create',['kode_pegawai' => Pegawai::getKodepegawai()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'kode_pegawai' => 'required|unique:pegawai,kode_pegawai',
            'nama_pegawai' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jabatan' => 'required|string|in:Manager,Kasir',
            'no_hp' => 'required|string|max:13', // 'max:13' karena 'no_hp' di database adalah 'varchar(13)
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['nama_pegawai'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        
        // Buat pegawai baru
        Pegawai::create([
            'kode_pegawai' => $validated['kode_pegawai'],
            'nama_pegawai' => $validated['nama_pegawai'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'jabatan' => $validated['jabatan'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
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
        User::destroy('id', $pegawai->user_id);

        return redirect('/');
    }
}