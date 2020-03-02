<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    public function user(){
      return $this->belongsTo('App\User', 'id_user');
    }

    public function buku(){
      return $this->belongsTo('App\Buku', 'id_buku');
    }

    public $timestamps = false;

    protected $fillable = [
      "id_user", "id_buku","denda", "tanggal_pinjam", "tanggal_kembali"
    ];

    protected $guarded = [];
}
