<?php

namespace App\Http\Controllers;
use App\Buku;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        if($request->search_query != ''){
            $Bukus = Buku::where('judul_buku','like','%'.$request->search_query.'%')
            ->orWhere('pengarang', 'like', '%'.$request->search_query.'%')
            ->orWhere('tahun_terbit', 'like', '%'.$request->search_query.'%')
            ->orWhere('penerbit', 'like', '%'.$request->search_query.'%')
            ->orWhere('lokasi_rak', 'like', '%'.$request->search_query.'%')
            ->orWhere('jenis_buku', 'like', '%'.$request->search_query.'%')
            ->paginate(10);
            
            if ($Bukus->isEmpty()){
                return response()->json([
                    'kosong' => 'Buku tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'buku' => $Bukus->appends($request->only('search_query'))
            ]);
        }
    }
}
