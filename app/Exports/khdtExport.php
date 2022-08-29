<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;

class khdtExport implements WithEvents
{
    public $masv;
    public $manganh;
    public $mahtdt;

    public function __construct($masv, $manganh, $mahtdt){
        $this -> masv = $masv;
        $this -> manganh = $manganh;
        $this -> mahtdt = $mahtdt;
    }

    public function registerEvents():array
    {
        return [
            BeforeWriting::class => function(beforeWriting $event){
                $templateFille = new LocalTemporaryFile(storage_path('mauin.xlsx'));
                $event -> writer -> reopen($templateFille, Excel::XLSX);
                $sheet = $event -> writer -> getSheetByIndex(0);
                
                $this->populateSheet($sheet);
                
                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }

    private function populateSheet($sheet){
        $sinhvien = DB::table('sinhvien') -> where('masv', $this -> masv) -> get();
        $sv_ctdt = DB::table('sinhvien_ctdt') -> where('masv', $this -> masv) -> get();
        $nganh = DB::table('nganh') -> where('manganh', $this -> manganh) -> get();
        $htdt = DB::table('htdt') -> where('mahtdt', $this -> mahtdt) -> get();

        foreach($nganh as $item){
            $tennganh = $item -> tennganh;
        }
        foreach($htdt as $item){
            $tenhtdt = $item -> tenhtdt;
        }
        $tongtinchi = 0;
        $tongtinchilt = 0;
        $tongsotietlt = 0;
        $tongsotietth = 0;
        $tongtinchith = 0;
        foreach($sv_ctdt as $key => $item){
            $mahe = $item -> mahe;
            $tongtinchi += $item -> tinchi;
            $tongtinchilt += $item -> tinchilt;
            $tongsotietlt += $item -> sotietlt;
            $tongsotietth += $item -> sotietth;
            $tongtinchith += $item -> tinchith;
        }

        $he = DB::table('he') -> where('mahe', $mahe) -> get();
        foreach($he as $item){
            $tenhe = $item -> tenhtdt;
        }
        $title = 'kế hoạch đào tạo ngành '.$tennganh.' '.$tenhtdt.' '.$tenhe;
        // Populate the static cells
        $sheet->setCellValue('A5', $title) -> alignment() -> setWrapText(true);
        
    }
    
}
