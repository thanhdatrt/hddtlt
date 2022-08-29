<?php

namespace App\Imports;

use DateTime;
use App\Models\SinhvienModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithLimit;

class ExcelImportSinhvien implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $startRow;
    
    public function __construct(int $startRow)
    {
        $this->startRow = $startRow;
    }

    public function startRow(): int
    {
        return $this->startRow;
    }

    public function model(array $row)
    {
        return new SinhvienModel([
            'masv'          => $row[0],
            'mahs'          => $row[1],
            'mahe'          => $row[2],
            'mahtdt'        => $row[3],
            'hoten'         => $row[4],
            'ngaysinh'      => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format('d/m/Y'),
            'malop'         => $row[6],
            'khoactdt'      => $row[7],
            'makhoa'        => $row[8],
            'manganh'       => $row[9],
            'ghichu'        => "",
            'status'        => 1,
            'role'          => 0,
            'created_at'    => new DateTime('now'),
        ]);
    }
}
