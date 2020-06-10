<?php

use App\User;
use App\Buku;
use App\Peminjaman;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Peminjaman::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween($startDate = '-1 weeks', $endDate = '+1 days', $timezone = null);
    return [
      'id_user' => User::all()->random()->id,
      'id_buku' => Buku::all()->random()->id,
      'tanggal_pinjam' => Carbon::createFromTimeStamp($date->getTimestamp()),
      'tanggal_kembali' => Carbon::createFromTimeStamp($date->getTimestamp())->addDays(3)
    ];
});
