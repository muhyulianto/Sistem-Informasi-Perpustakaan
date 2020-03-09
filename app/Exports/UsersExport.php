<?php

namespace App\Exports;

use App\Pengembalian;
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
        return Pengembalian::with(['user', 'buku'])->get();
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

    public function map($pengembalian): array
    {
        return [
            $pengembalian->id,
            $pengembalian->user->name,
            $pengembalian->buku->judul_buku,
            $pengembalian->tanggal_pinjam,
            $pengembalian->tanggal_kembali,
            $pengembalian->dikembalikan_tanggal,
            $pengembalian->telat,
            $pengembalian->denda
        ];
    }

}
