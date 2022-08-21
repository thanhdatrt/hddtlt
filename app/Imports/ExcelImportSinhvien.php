<?php

namespace App\Imports;

use DateTime;
use App\Models\SinhvienModel;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImportSinhvien implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SinhvienModel([
            'masv' => $row[0],
            'mahs' => $row[1],
            'mahe' => $row[2],
            'mahtdt' => $row[3],
            'hoten' => $row[4],
            'ngaysinh' => $row[5],
            'malop' => $row[6],
            'khoactdt' => $row[7],
            'makhoa' => $row[8],
            'manganh' => $row[9],
            'ghichu' => "",
            'status' => 1,
            'created_at' => new DateTime('now'),
        ]);
    }
}
