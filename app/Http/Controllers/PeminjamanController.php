<?php

namespace App\Http\Controllers;

use App\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use DB;

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
            $peminjaman = Peminjaman::with(['user', 'buku'])->where('id_user', $request->id)->orderBy('tanggal_pinjam', 'desc')->paginate(10);
            return response()->json([
                'data_peminjaman' => $peminjaman
            ]);
        } else if ($request->has('search_query')) {
            $peminjaman = peminjaman::with(['user', 'buku'])
                ->whereHas('user', function($query) use ($request){
                    $query->where('name', 'like', "%{$request->search_query}%"); 
                })->orWhereHas('buku', function ($query) use ($request) {
                    $query->where('judul_buku', 'like',  "%{$request->search_query}%");
                })->orderBy('tanggal_pinjam', 'desc')->paginate(10);

          return response()->json([
              'data_peminjaman' => $peminjaman
          ]);
        }

        $peminjaman = Peminjaman::with(['user', 'buku'])->orderBy('tanggal_pinjam', 'desc')->paginate(10);

        return response()->json([
            'data_peminjaman' => $peminjaman
        ]);

    }

    /**
     * Show the data for dashboard menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $userMeminjamBukuHariIni = Peminjaman::whereDate('tanggal_pinjam', Carbon::today())->distinct("id_user")->count("id_user");

        $bukuDiPinjamHariIni = Peminjaman::whereDate('tanggal_pinjam', Carbon::today())->count();

        $bukuPalingBanyakPinjam = Peminjaman::select('id_buku')
            ->with('buku')
            ->selectRaw('count(id_buku) as jumlah')
            ->groupBy('id_buku')
            ->orderBy('jumlah', 'DESC')
            ->limit(1)
            ->get();

        $userPalingBanyakMeminjam = Peminjaman::select('id_user')
            ->with('user')
            ->selectRaw('count(id_user) as jumlah')
            ->groupBy('id_user')
            ->orderBy('jumlah', 'DESC')
            ->limit(1)
            ->get();

        return response() -> json([
            'userMeminjamBukuHariIni' => $userMeminjamBukuHariIni,
            'bukuDiPinjamHariIni' => $bukuDiPinjamHariIni,
            'userPalingBanyakMeminjam' => $userPalingBanyakMeminjam,
            'bukuPalingBanyakPinjam' => $bukuPalingBanyakPinjam
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $jumlah = Peminjaman::where('id_user', $request->id_user)
        ->where('tanggal_pinjam', '>=', Carbon::today())
        ->count();

        $validate = Validator::make($request->all(), [
          'id_buku' => 'unique:peminjamen,id_buku,NULL,id,id_user,'.$request->id_user
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors'=> 'Buku sudah anda pinjam',
            ], 422);
        } else if ( $jumlah > 2) {
            return response()->json([
                'errors'=> 'Anda hanya dapat meminjam 3 buku per hari',
            ], 422);
        }

        Peminjaman::create($request->all());
    }

    /**
     * Get data for chart js.
     *
     * @param  \App\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function chartData()
    {
        $chartdata = Peminjaman::select(DB::raw('DATE(tanggal_pinjam) as date'))
            ->selectRaw('count(tanggal_pinjam) as jumlah')
            ->where('tanggal_pinjam', '>=',carbon::now()->subDays('7'))
            ->orderBy('tanggal_pinjam')
            ->groupBy('date')
            ->get();
        
        return response()->json([
            'chartdata' => $chartdata
        ]);
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
