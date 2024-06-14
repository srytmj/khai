<?php

namespace App\Http\Controllers;

use App\Models\gaji;
use App\Models\pegawai;
use App\Http\Requests\StoregajiRequest;
use App\Http\Requests\UpdategajiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('gaji/view', [
            'gaji' => gaji::with('pegawai')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gaji/create', [
            'pegawai' => pegawai::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->status_kehadiran == 'hadir') {
            $validated = $request->validate([
                'kode_pegawai' => 'required',
                'status_kehadiran' => 'required',
                'perjam' => 'required',
                'jam_kerja' => 'required',
            ]);
            $validated['keterangan'] = 'Tidak diisi';
        } elseif ($request->status_kehadiran == 'sakit') {
            $validated = $request->validate([
                'kode_pegawai' => 'required',
                'status_kehadiran' => 'required',
                'keterangan' => 'required',
            ]);
            $validated['perjam'] = '0';
            $validated['jam_kerja'] = '0';
        } elseif ($request->status_kehadiran == 'alpa') {
            $validated = $request->validate([
                'kode_pegawai' => 'required',
                'status_kehadiran' => 'required',
            ]);
            $validated['perjam'] = '0';
            $validated['jam_kerja'] = '0';
            $validated['keterangan'] = 'Tidak diisi';
        }

        $gaji = gaji::create($validated);

        // query dapatkan nilai nominal transaksi
        // $id_gaji = gaji::find($gaji->id);
        $data_penggajian = gaji::find($gaji->id);

        //catat ke jurnal
        DB::table('jurnal')->insert([
            'id_transaksi' => $data_penggajian->id,
            'id_perusahaan' => 1, //bisa diganti kalau sudah live
            'kode_akun' => '501',
            'tgl_jurnal' => now(),
            'posisi_d_c' => 'd',
            'nominal' => $data_penggajian->perjam * $data_penggajian->jam_kerja,
            'kelompok' => 1,
            'transaksi' => 'penggajian',
        ]);

        DB::table('jurnal')->insert([
            'id_transaksi' => $data_penggajian->id,
            'id_perusahaan' => 1, //bisa diganti kalau sudah live
            'kode_akun' => '111',
            'tgl_jurnal' => now(),
            'posisi_d_c' => 'c',
            'nominal' => $data_penggajian->perjam * $data_penggajian->jam_kerja,
            'kelompok' => 4,
            'transaksi' => 'penggajian',
        ]);

        return redirect('/gaji')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(gaji $gaji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(gaji $gaji)
    {
        $gaji->load('pegawai');
        return view('gaji.edit', compact('gaji'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, gaji $gaji)
    {
        if ($request->status_kehadiran == 'hadir') {
            $validated = $request->validate([
                'kode_pegawai' => 'required',
                'status_kehadiran' => 'required',
                'perjam' => 'required',
                'jam_kerja' => 'required',
            ]);
            $validated['keterangan'] = 'Tidak diisi';
        } elseif ($request->status_kehadiran == 'sakit') {
            $validated = $request->validate([
                'kode_pegawai' => 'required',
                'status_kehadiran' => 'required',
                'keterangan' => 'required',
            ]);
            $validated['perjam'] = '0';
            $validated['jam_kerja'] = '0';
        } elseif ($request->status_kehadiran == 'alpa') {
            $validated = $request->validate([
                'kode_pegawai' => 'required',
                'status_kehadiran' => 'required',
            ]);
            $validated['perjam'] = '0';
            $validated['jam_kerja'] = '0';
            $validated['keterangan'] = 'Tidak diisi';
        }

        gaji::where('id', $gaji->id)->update($validated);

        return redirect('/gaji')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //hapus dari database
        $gaji = gaji::findOrFail($id);
        $gaji->delete();

        return redirect('/gaji')->with('success', 'Data Berhasil di Hapus');
    }
}
