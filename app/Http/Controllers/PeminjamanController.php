<?php

namespace App\Http\Controllers;

use App\Peminjaman;
use App\User;
use Illuminate\Http\Request;
use Validator;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('id')){
            $Peminjaman = Peminjaman::where('id_user', $request->id);

            return response()->json([
              'data_peminjaman' => $Peminjaman->with(['user', 'buku'])->paginate(10)
            ]);
        }

        $peminjaman = Peminjaman::with(['user', 'buku'])->paginate(10);

        return response()->json([
          'data_peminjaman' => $peminjaman
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
            'unique' => 'Anda sudah meminjam buku ini'
        ];

        $validate = Validator::make($request->all(), [
            'id_buku' => 'unique:peminjamen,id_buku,NULL,id,id_user,'.$request->id_user
        ], $messages);

        if ($validate->fails()) {
            return response()->json([
                'errors'=> $validate->messages(),
            ], 422);
        }

        Peminjaman::create($request->all());
    }

    /**
     * display the specified resource.
     *
     * @param  \App\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
