<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
	public function user(){
		return $this->belongsTo('App\User', 'id_user');
	}

	public function buku(){
		return $this->belongsTo('App\Buku', 'id_buku');
	}

	protected $fillable = [
		"id_user", "id_buku", "tanggal_pinjam", "tanggal_kembali"
	];

	protected $guarded = [];
	
	/**
	 * 
	 * MUTATOR
	 *
	 */
	public function setTanggalPinjamAttribute($value) {
		return $this->attributes['tanggal_pinjam'] = Carbon::createFromFormat('Y-m-d H:i:s', $value);
	}

}
