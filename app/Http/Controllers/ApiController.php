<?php

namespace App\Http\Controllers;

// untuk mengakses http
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    // untuk tes response dari API
    public function index()
    {
        $response = Http::get('https://newsapi.org/v2/everything?q=kopi&language=id&from=2021-0429&sortBy=popularity&apiKey=1d7f2ad5815e49fa85fabab5ff37c455');
        $hasil = json_decode($response);
        // var_dump($hasil);

        if($hasil->status=="ok"){
            echo "Jumlah Status     : ".$hasil->status."<br>";
            echo "Jumlah Results    : ".$hasil->totalResults."<br>";
            echo "Sumber Artikel-1  : ".$hasil->articles[0]->source->name."<br>";
            echo "Nama Artikel-2    : ".$hasil->articles[1]->title."<br>";
            echo "URL Gambar        : ".$hasil->articles[1]->urlToImage."<br>";

            // dapatkan jumlah datanya
            echo "<hr>";
            foreach ($hasil->articles as $row){
                echo $row->source->name."-".$row->author."-".$row->title."-".$row->url."-".$row->description."-".$row->urlToImage;
                echo "<br>"; 
            } 
               
        }
    }

    // untuk galeri api
    public function getNews(){
        // akses API
        $url = 'https://newsapi.org/v2/everything?q=kopi&language=id&from=2021-0429&sortBy=popularity&apiKey=1d7f2ad5815e49fa85fabab5ff37c455';
        $response = Http::get($url);
        $hasil = json_decode($response);
        // var_dump($hasil);
        return view(
            'api.api1',
            [
                'hasil' => $hasil
            ]
        );
    }

    // untuk galeri api
    public function getWiki(){
        // Access API
        $url = 'https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=Kopi&format=json';
        $response = Http::get($url);
        $hasil = json_decode($response->getBody()->getContents());
    
        // Pass only the search results to the view
        $articles = $hasil->query->search;
    
        return view('api.api2', ['articles' => $articles]);
    }
    
}
