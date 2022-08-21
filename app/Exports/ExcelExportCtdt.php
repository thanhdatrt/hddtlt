<?php

namespace App\Exports;

use App\Models\CtdtModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExportCtdt implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CtdtModel::all();
    }
}
