# Sistem-Informasi-Perpustakaan

Sistem Informasi Perpustakaan adalah sistem yang dibuat untuk memudahkan petugas perpustakaan dalam mengelola suatu perpustakaan.
Semua di proses secara komputerisasi yaitu digunakannya suatu software tertentu seperti software pengolah database.
Petugas perpustakaan dapat selalu memonitor tentang ketersediaan buku, daftar buku baru, peminjaman buku dan pengembalian buku.
Fungsi interaktif yang dimiliki sistem ini adalah fasilitas pencarian buku berdasarkan beberapa kategori
yaitu judul buku, penerbit, tahun terbit, pengarang, atau tempat buku serta informasi buku lain yang berhubungan
dengan buku yang dicari oleh pengunjung perpustakaan agar buku mudah ditemukan.

## Cara penginstallan.

Software yang diperlukan:

1. [XAMPP ( sejenisnya )]( https://www.apachefriends.org/index.html)
2. <a href="http://composer.org">Composer</a>

### Hal yang perlu di install:
```
1. PHP >= 7.0.0
2. OpenSSL PHP Extension
3. PDO PHP Extension
4. Mbstring PHP Extension
5. Tokenizer PHP Extension
6. XML PHP Extension 
```
Anda bisa baca selengkapnya disini <a href="https://laravel.com/docs/5.5#server-requirements">Laravel 5.5 Server requirements</a>

### Cara penginstallan
```
1. Clone repository ke local direktori anda.
2. Masuk ke direktori penginstallan.
3. Buka terminal / cmd ketik "composer install" dan tekan enter untuk menginstall dependency php.
4. Ketik "npm install" untuk menginstall package javascript.
5. Setting file .env sesuai database anda.
6. Jalankan sistem di browser.
7. Jika ada error jalankan "php artisan:key generate" dan
8. "php artisan jwt:secret".
```

## Built With

* [Laravel 5.5](https://laravel.com/docs/5.5) - The php framework used
* [Vue](https://vuejs.org/) - Javascript Framework
* [Bootstrap 4.4.1](https://getbootstrap.com/) - Front-end component library

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
