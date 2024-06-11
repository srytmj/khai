<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 
class Contoh1Controller extends Controller
{
    public function show()
    {
        return "Halo, ini adalah contoh kontroller sederhana tanpa view";
    }

    // coba tes dom
    public function contohdom(){
        return view('contohdom');
    }

    // coba tes ajax
    public function contohajax(){
        return view('contohajax');
    }
}