<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Buku;
use Validator;
use Excel;
use File;
use Session;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Bukus = Buku::where('judul_buku','like','%'.$request->search_query.'%')
            ->orWhere('pengarang', 'like', '%'.$request->search_query.'%')
            ->orWhere('tahun_terbit', 'like', '%'.$request->search_query.'%')
            ->orWhere('penerbit', 'like', '%'.$request->search_query.'%')
            ->orWhere('lokasi_rak', 'like', '%'.$request->search_query.'%')
            ->orWhere('jenis_buku', 'like', '%'.$request->search_query.'%')
            ->orderBy('judul_buku')
            ->paginate($request->entries);

        return response()->json([
            'data_buku' => $Bukus->appends($request->only('search_query'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'unique' => 'Data telah tersedia di database!'
        ];

        $validator = Validator::make($request->all(), [
            'judul_buku' => 'unique:bukus,judul_buku',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors'=> $validator->messages(),
                'judul_buku' => $request -> judul_buku
            ], 422);
        }

        $fileImage = $request->file('image');
        $fileImage->move(base_path('/public/uploads'), $fileImage->getClientOriginalName());
        Buku::create([
          'judul_buku' => $request->judul_buku,
          'pengarang' => $request->pengarang,
          'tahun_terbit' => $request->tahun_terbit,
          'penerbit' => $request->penerbit,
          'jenis_buku' => $request->jenis_buku,
          'lokasi_rak' => $request->lokasi_rak,
          'namaGambar' => $fileImage->getClientOriginalName()
        ]);
        return response()->json(['berhasil' => "Data telah di tambahkan"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Bukus = Buku::find($id);
        return response()->json($Bukus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fileImage = $request->file('image');
        $fileImage->move(base_path('/public/uploads'), $fileImage->getClientOriginalName());

        $Bukus = Buku::findOrFail($id);
        $Bukus->judul_buku = $request->judul_buku;
        $Bukus->pengarang = $request->pengarang;
        $Bukus->tahun_terbit = $request->tahun_terbit;
        $Bukus->penerbit = $request->penerbit;
        $Bukus->jenis_buku = $request->jenis_buku;
        $Bukus->lokasi_rak = $request->lokasi_rak;
        $Bukus->namaGambar = $fileImage->getclientoriginalname();
        $Bukus->save();
        return response()->json($Bukus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Buku::find($id)->delete();
    }
}
