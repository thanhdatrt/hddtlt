<?php

namespace App\Imports;

use DateTime;
use App\Models\MonhocModel;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
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
