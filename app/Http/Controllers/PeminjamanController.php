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
     *
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        // jika bukan admin
        if ($request->has('id')){

            $peminjaman = Peminjaman::with(['user', 'buku'])
                ->where('id_user', $request->id)
                ->whereNull('dikembalikan_tanggal')
                ->orderBy('tanggal_pinjam', 'desc')
                ->paginate($request->entries);

            return response()->json([
                'data_peminjaman' => $peminjaman
            ]);

        }

        // Jika admin
        else {

            // mengambil buku yang sudah dikembalikan
            if ($request->has('pengembalian')) {
                $peminjaman = peminjaman::with(['user', 'buku'])
                    ->whereHas('user', function($query) use ($request){
                        $query->where('name', 'like', "%{$request->search_query}%")
                        ->whereNotNull('dikembalikan_tanggal');
                    })->orWhereHas('buku', function ($query) use ($request) {
                        $query->where('judul_buku', 'like',  "%{$request->search_query}%")
                        ->whereNotNull('dikembalikan_tanggal');
                    })
                    ->orderBy('dikembalikan_tanggal', 'desc')->paginate(10);

                return response()->json([
                  'data_peminjaman' => $peminjaman
                ]);
            }
            
            // mengambil buku belum dikembalikan
            $peminjaman = peminjaman::with(['user', 'buku'])
                ->whereHas('user', function($query) use ($request){
                    $query->where('name', 'like', "%{$request->search_query}%")
                    ->whereNull('dikembalikan_tanggal');
                })->orWhereHas('buku', function ($query) use ($request) {
                    $query->where('judul_buku', 'like',  "%{$request->search_query}%")
                    ->whereNull('dikembalikan_tanggal');
                })
                ->orderBy('tanggal_pinjam', 'desc')->paginate($request->entries);

            return response()->json([
              'data_peminjaman' => $peminjaman
            ]);

        }

    }

    /**
     *
     * Show the data for dashboard menu.
     *
     */
    public function dashboard()
    {
        $userMeminjamBukuHariIni = Peminjaman::whereDate('tanggal_pinjam', Carbon::today())
            ->distinct("id_user")
            ->count("id_user");

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

    /*
     *
     * Store a newly created resource in storage.
     *
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
     *
     * Get data for chart js.
     *
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
     * 
     * Fungsi untuk mengembalikan buku
     *
     **/
    public function kembalikanBuku(Request $request)
    {
        // Mencari data berdasarkan id
        $data_peminjaman = Peminjaman::find($request->id);
        $date = strtotime($data_peminjaman->tanggal_kembali);
        if(carbon::now() > $data_peminjaman->tanggal_kembali){
          $telat = round(abs(strtotime(carbon::now()) - $date) / 86400);
        } else {
          $telat = 0;
        }

        $dikembalikan_tanggal = carbon::now();
        $denda = $telat * 500;

        $data_peminjaman->dikembalikan_tanggal = $dikembalikan_tanggal;
        $data_peminjaman->telat = $telat;
        $data_peminjaman->denda = $denda;
        $data_peminjaman->save();

    }

    /**
     *
     * Donwload data as excel
     *
     **/
    public function download()
    {
       return Excel::download(new UsersExport, 'users.xlsx'); 
    }


}
