<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TransaksiImport implements ToCollection, ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return new Transaksi([
            'tanggal'       => $row['tanggal'],
            'kategori'      => $row['kategori'], 
            'keterangan'    => $row['keterangan'],
            'nominal'       => $row['nominal'],
        ]);
    }
}
