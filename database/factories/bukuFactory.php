<?php

use Faker\Generator as Faker;

$factory->define(App\Buku::class, function (Faker $faker) {
  return [
      'judul_buku' => $faker->text($maxNbChars = 20),
      'pengarang' => $faker->firstNameMale,
      'tahun_terbit' => intval($faker->year($max = 'now')),
      'penerbit' => $faker->company,
      'jenis_buku' => $faker->randomElement($array = array ('tutorial','sains','cerita')),
      'lokasi_rak' => $faker->randomElement($array = array ('A1','B2','C3')),
      'namaGambar' => 'placeholder.jpg'
    ];
});
