<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buku;
use Validator;
use Excel;
use File;
use Session;

class ExcelController extends Controller
{

    public function export(){
        return view('data.export');
    }

    public function import_excel(Request $request)
    {
        // Get current data from items table
        $nama_bukus = Buku::pluck('nama_buku')->toArray();

        if($request->hasFile('excel')){
            $extension = File::extension($request->excel->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $path = $request->excel->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();
                if(!empty($data) && $data->count()){

                    $insert = array();

                    foreach ($data as $key => $value) {

                        // Skip title previously added using in_array
                        if (in_array($value->nama_buku, $nama_bukus))
                            continue;

                        $insert[] = [
                        'nama_buku' => $value->nama_buku,
                        'pengarang' => $value->pengarang,
                        'tahun_terbit' => $value->tahun_terbit,
                        'penerbit' => $value->penerbit,
                        'rak' => $value->rak,
                        'jenis_buku' => $value->jenis_buku,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')
                        ];

                        // Add new title to array
                        $nama_bukus[] = $value->nama_buku;
                    }

                    if(!empty($insert)){
                        foreach ($insert as $key => $value) {
                            $insertData = Buku::firstOrCreate($value);
                        }
                        if ($insertData) {
                            Session::flash('success', 'Your Data has successfully imported');
                        }else {
                            Session::flash('error', 'Error inserting the data..');
                            return back();
                        }
                    }
                }

                return back();

            }else {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
    }

    public function export_excel(Request $request){

        $buku_data = Buku::orderBy($request->sort, 'asc')->get();

        $buku_array[] = array('nama_buku', 'pengarang', 'tahun_terbit', 'penerbit', 'rak', 'jenis_buku');
        foreach ($buku_data as $data) {
            $buku_array[] = array(
                'nama_buku' => $data->nama_buku,
                'pengarang' => $data->pengarang,
                'tahun_terbit' => $data->tahun_terbit,
                'penerbit' => $data->penerbit,
                'rak' => $data->rak,
                'jenis_buku' => $data->jenis_buku
            );
        }

        Excel::create('Data Buku', function($excel) use ($buku_array){
            $excel->setTitle('Data Buku');
            $excel->sheet('Data Buku', function($sheet) use ($buku_array){
                $sheet->fromArray($buku_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    public function template(){

        $buku_array[] = array(
            'nama_buku' => 'nama_buku',
            'pengarang' => 'pengarang',
            'tahun_terbit' => 'tahun_terbit',
            'penerbit' => 'penerbit',
            'rak' => 'rak',
            'jenis_buku' => 'jenis_buku'
        );

        Excel::create('Data Buku', function($excel) use ($buku_array){
            $excel->setTitle('Data Buku');
            $excel->sheet('Data Buku', function($sheet) use ($buku_array){
                $sheet->fromArray($buku_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }
}
