<?php

namespace App\Imports;

use DateTime;
use App\Models\MonhocModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithLimit;

class ExcelImport implements ToModel, WithStartRow
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
        return new MonhocModel([
            'mahp' => $row[0],
            'tenhp' => $row[1],
            'tinchi' => $row[2],
            'tinchilt' => $row[3],
            'sotietlt' => $row[4],
            'tinchith' => $row[5],
            'sotietth' => $row[6],
            'ghichuhp' => $row[7],
            'status' => $row[8],
            'create_at' => new dateTime('now'),
        ]);
    }

}
