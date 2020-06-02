<?php

namespace App\Http\Controllers;

use App\Peminjaman;
use App\Buku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Exports\UsersExport;

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
                ->orderBy('created_at', 'desc')
                ->paginate($request->entries);

            return response()->json([
                'data_peminjaman' => $peminjaman
            ]);

        }

        // Jika admin
        else {
            // mengambil buku yang sudah dikembalikan
            if ($request->has('pengembalian')) {
                // Mengambil riwayat peminjaman terakhir user yang dipilih
                if ($request->has('id_user')) {
                    $peminjaman = peminjaman::with(['buku', 'user'])
                        ->where('id_user', $request->id_user)
                        ->orderBy('tanggal_pinjam', 'DESC')
                        ->paginate($request->entries);

                    return response()->json([
                        'data_peminjaman' => $peminjaman
                    ]);
                }

                $peminjaman = peminjaman::with(['user', 'buku'])
                    ->whereHas('user', function($query) use ($request){
                        $query->where('name', 'like', "%{$request->search_query}%")
                        ->whereNotNull('dikembalikan_tanggal');
                    })->orWhereHas('buku', function ($query) use ($request) {
                        $query->where('judul_buku', 'like',  "%{$request->search_query}%")
                        ->whereNotNull('dikembalikan_tanggal');
                    })
                    ->orderBy('created_at', 'desc')->paginate($request->entries);

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
                ->orderBy('created_at', 'desc')->paginate($request->entries);

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
            ->first();

        $userPalingBanyakMeminjam = Peminjaman::select('id_user')
            ->with('user')
            ->selectRaw('count(id_user) as jumlah')
            ->groupBy('id_user')
            ->orderBy('jumlah', 'DESC')
            ->first();

        return response() -> json([
            'userMeminjamBukuHariIni' => $userMeminjamBukuHariIni,
            'bukuDiPinjamHariIni' => $bukuDiPinjamHariIni,
            'userPalingBanyakMeminjam' => $userPalingBanyakMeminjam,
            'bukuPalingBanyakPinjam' => $bukuPalingBanyakPinjam
        ]);
    }
    
    /**
     * 
     * Show the data for dashboard menu user.
     * 
     */
    public function dashboard_user(Request $request) {
        $jumlah_pinjam_hari_ini = Peminjaman::where('id_user', $request->id_user)
            ->whereDate('tanggal_pinjam', Carbon::today())
            ->count();
        
        $jumlah_pinjam_hari_all = Peminjaman::where('id_user', $request->id_user)
            ->count();

        $buku_sering_dipinjam = Peminjaman::select('id_buku')
            ->where('id_user', $request->id_user)
            ->with('buku')
            ->selectRaw('count(id_buku) as jumlah')
            ->groupBy('id_buku')
            ->orderBy('jumlah', 'DESC')
            ->first();

        $buku_terakhir_dipinjam = Peminjaman::where('id_user', $request->id_user)
            ->with('buku')
            ->orderBy('created_at', 'DESC')
            ->first();
        
        $daftar_buku_baru = Buku::orderBy('created_at', 'DESC')
        ->take(5)
        ->get();

        return response() -> json([
            'jumlah_pinjam_all' => $jumlah_pinjam_hari_all,
            'jumlah_pinjam_hari_ini' => $jumlah_pinjam_hari_ini,
            'buku_sering_dipinjam' => $buku_sering_dipinjam,
            'buku_terakhir_dipinjam' => $buku_terakhir_dipinjam,
            'daftar_buku_baru' => $daftar_buku_baru
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
        // Data tanggal selama 7 hari
        foreach(range(0, 7) as $day) {
            $dates[] = Carbon::now()->subDays($day)->format('yy-m-d');
            $tanggal = array_reverse($dates);
        }

        // Jumlah buku yang dipinjam per hari selama 1 mingggu
        foreach($tanggal as $date){
            $chartdata = Peminjaman::select(DB::raw('DATE(tanggal_pinjam) as date'))
                ->selectRaw('count(tanggal_pinjam) as jumlah')
                ->where('tanggal_pinjam', 'like', '%'.$date.'%')
                ->orderBy('tanggal_pinjam')
                ->groupBy('date')
                ->pluck('jumlah')
                ->toArray();

           if($chartdata){
               $jumlah[] = $chartdata[0];
           }else {
               $jumlah[] = 0;
           }
        }
        
        return response()->json([
            'jumlah' => $jumlah,
            'tanggal' => $tanggal
        ]);
    }

    /**
     *
     * Get data for chart js for user
     *
     */
    public function chartDataUser($id)
    {
        // Data tanggal selama 7 hari
        $start = Carbon::now()->subDays(7);
        foreach (range(0, 7) as $day) {
            $dates[] = $start->addDays(1)->format('yy-m-d');
        }

        // Jumlah buku yang dipinjam per hari selama 1 mingggu
        foreach($dates as $date){
            $chartdata = Peminjaman::select(DB::raw('DATE(tanggal_pinjam) as date'))
                ->selectRaw('count(tanggal_pinjam) as jumlah')
                ->where('tanggal_pinjam', 'like', '%'.$date.'%')
                ->where('id_user', $id)
                ->orderBy('tanggal_pinjam')
                ->groupBy('date')
                ->pluck('jumlah')
                ->toArray();

           if($chartdata){
               $result[] = $chartdata[0];
           }else {
               $result[] = 0;
           }
        }
        
        return response()->json([
            'chartdata' => $dates,
            'jumlahdata' => $result
        ]);
    }

    /**
     * 
     * fungsi untuk mengembalikan buku
     *
     **/
    public function kembalikanbuku(request $request)
    {
        // mencari data berdasarkan id
        $data_peminjaman = peminjaman::find($request->id);
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
       return \Excel::download(new UsersExport, 'data_buku_yang_dipinjam.xlsx'); 
    }


}
