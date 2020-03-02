<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->nullable();
            $table->integer('id_buku')->nullable();
            $table->dateTime('tanggal_pinjam')->nullable();
            $table->dateTime('tanggal_kembali')->nullable();
            $table->dateTime('dikembalikan_tanggal')->nullable();
            $table->integer('telat')->nullable();
            $table->integer('denda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalians');
    }
}
