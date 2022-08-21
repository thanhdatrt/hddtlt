<?php

namespace App\Imports;

use DateTime;
use App\Models\CtdtModel;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImportCtdt implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CtdtModel([
            'manganh' => $row[0], 
            'mahe' => $row[1], 
            'khoactdt' => $row[2], 
            'stt' => $row[3], 
            'mahp' => $row[4], 
            'tuchon' => $row[5], 
            'sotinchitc' => $row[6],
            'status' => 1, 
            'create_at' => new dateTime('now'),
        ]);
    }
}
