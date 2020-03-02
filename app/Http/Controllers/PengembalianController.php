<?php

namespace App\Http\Controllers;

use App\Peminjaman;
use App\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Pengembalian = Pengembalian::with(['user', 'buku'])->orderBy('dikembalikan_tanggal', 'desc')->paginate(10);

        return response()->json([
            'data_pengembalian' => $Pengembalian
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
      // Mencari data berdasarkan id
      $data_peminjaman = Peminjaman::where('id', $request->id)->first();
      $date = strtotime($data_peminjaman->tanggal_kembali);
      if(Carbon::now() > $data_peminjaman->tanggal_kembali){
        $telat = round(abs(strtotime(Carbon::now()) - $date) / 86400);
      } else {
        $telat = 0;
      }
      // Menyimpan data ke dalam variable
      $id_user = $data_peminjaman->id_user;
      $id_buku = $data_peminjaman->id_buku;
      $tanggal_pinjam = $data_peminjaman->tanggal_pinjam;
      $tanggal_kembali = $data_peminjaman->tanggal_kembali;
      $dikembalikan_tanggal = Carbon::now();
      $denda = $telat * 500;
      // Delete data terpilih
      $data_peminjaman->delete();
      // Membuat data baru
      $data_pengembalian = new Pengembalian();
      $data_pengembalian->id_user = $id_user;
      $data_pengembalian->id_buku = $id_buku;
      $data_pengembalian->tanggal_pinjam = $tanggal_pinjam;
      $data_pengembalian->tanggal_kembali = $tanggal_kembali;
      $data_pengembalian->dikembalikan_tanggal = $dikembalikan_tanggal;
      $data_pengembalian->telat = $telat;
      $data_pengembalian->denda = $denda;
      // Menyimpan data
      $data_pengembalian->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function show(pengembalian $pengembalian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function edit(pengembalian $pengembalian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pengembalian $pengembalian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengembalian $pengembalian)
    {
        //
    }
}
