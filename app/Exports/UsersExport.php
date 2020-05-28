<?php

namespace App\Exports;

use App\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Peminjaman::with(['user', 'buku'])->whereNotNull('dikembalikan_tanggal')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nama user',
            'judul buku',
            'tanggal_pinjam',
            'tanggal_kembali',
            'dikembalikan_tanggal',
            'telat (Hari)',
            'denda (Rupiah)'
        ];
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->id,
            $peminjaman->user->name,
            $peminjaman->buku->judul_buku,
            $peminjaman->tanggal_pinjam,
            $peminjaman->tanggal_kembali,
            $peminjaman->dikembalikan_tanggal,
            $peminjaman->telat,
            $peminjaman->denda
        ];
    }

}
