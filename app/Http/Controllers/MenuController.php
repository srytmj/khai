<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // Import model Muzakki

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::all();
        
        // Tampilkan view dengan data muzakki
        return view("menu.view", [
            "menu" => $menu
        ]);
    }

    public function create()
    {
        // Tampilkan view untuk membuat menu baru
        return view('menu.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $isi = $request->validate([
            'kode_menu' => 'required',
            'nama_menu' => 'required',
            'harga_menu' => 'required',
        ]);

        // Simpan data menu baru ke database
        Menu::create($isi);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function show($id)
    {
        // // Ambil data menu berdasarkan ID
        // $menu = Menu::findOrFail($id);

        // // Tampilkan view untuk menampilkan detail menu
        // return view('menu.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('/menu/edit', [
            'menu' => $menu
        ]);
    }


    public function update(Request $request, Menu $menu)
    {
        $isi = $request->validate([
            'kode_menu' => 'required',
            'nama_menu' => 'required',
            'harga_menu' => 'required',
        ]);

        Menu::where('id', $menu->id)
        ->update($isi);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('menu.index')
            ->with('success', 'Data Menu berhasil diubah.');
    }

    public function destroy($id)
    {
        // Hapus data menu berdasarkan ID
        $menu = Menu::findOrFail($id);
        $menu->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('menu.index')
            ->with('success', 'Data Menu berhasil dihapus.');
    }
}