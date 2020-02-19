<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'judul_buku', 'pengarang', 'tahun_terbit', 'penerbit', 'jenis_buku', 'lokasi_rak', 'namaGambar'
    ];

    protected $guarded = [];
}
