<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchApiController extends Controller
{
    // tampilan depan products
    public function index(){
        return view('products');
    }

    // ambil data products dari api products yang telah dibuat di ApiController
    public function fetch() {
        set_time_limit(0);

        $fetch = Http::get("http://0.0.0.0:8000/api/products"); // agar host nya mengikuti ip komputer masing masing.

        if($fetch->failed()){
            return redirect()->route('products.index')->with('error', 'Pengambilan data API gagal.');
        }

        $data = $fetch->json();

        return redirect()->route('products.index')->with('Fetching data API selesai.');
    }
}
