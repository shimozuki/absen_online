<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Murid;


class MuridsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Murid([
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'kelas_id' => $row['kelas_id'],
            'tahun_id' => $row['tahun_id'],
        ]);
    }
}
