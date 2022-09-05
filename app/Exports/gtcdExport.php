<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class gtcdExport implements WithEvents
{
    public $masv; 
    public $mangan;
    public $mahtdt; 
    public $mahe; 
    public $makhoa;

    public function __construct($masv, $manganh, $mahtdt, $mahe, $makhoa){
        $this -> masv = $masv;
        $this -> manganh = $manganh;
        $this -> mahtdt = $mahtdt;
        $this -> mahe = $mahe;
        $this -> mahtdt = $mahtdt;
    }

    public function registerEvents():array
    {
        return [
            BeforeWriting::class => function(beforeWriting $event){
                $templateFille = new LocalTemporaryFile(storage_path('QDmiengiam.xlsx'));
                $event -> writer -> reopen($templateFille, Excel::XLSX);
                $sheet = $event -> writer -> getSheetByIndex(0);
                
                $this->populateSheet($sheet);
                
                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }

    private function populateSheet($sheet){
        $ctdt_sinhvien = DB::table('sinhvien_ctdt') -> where('masv', $this->masv) -> where('mientru', 1) -> get();
        $sinhvien = DB::table('sinhvien') -> where('masv', $this->masv) -> get();
        $nganh = DB::table('nganh') -> where('manganh', $this->manganh) -> get();
        $htdt = DB::table('htdt') -> where('mahtdt', $this->mahtdt) -> get();
        $he = DB::table('he') -> where('mahe', $this->mahe) -> get();
        $khoa = DB::table('khoahoc') -> where('makhoa', $this->makhoa) -> get();

        foreach($nganh as $item){
            $tennganh = $item -> tennganh;
        }
        foreach($htdt as $item){
            $tenhtdt    = $item -> tenhtdt;
        }
        foreach($he as $item){
            $tenhe      = $item -> he;
        }
        foreach($khoa as $item){
            $tenkhoa    = $item -> tenkhoa;
        }
        foreach($sinhvien as $item){
            $hoten      = $item -> hoten;
            $ngaysinh   = $item -> ngaysinh;
            $mahs       = $item -> mahs;
        }

        $sheet->setCellValue('C5', $tennganh);
        $bac = $tenhtdt.' '.$tenhe;
        $sheet->setCellValue('C6', $bac);
        

        $row = 11;
        $stt = 1;
        foreach($ctdt_sinhvien as $item){
            // Create cell definitions
            $A = "A".($row);
            $B = "B".($row);
            $C = "C".($row);
            $D = "D".($row);
            $E = "E".($row);
            $F = "F".($row);
            $G = "G".($row);
            $H = "H".($row);
            $I = "I".($row);

            $fullname = $hoten;
            $arrName = explode(" ", $fullname);

            $firstName = array_shift($arrName); // họ
            $lastName = array_pop($arrName); // tên
            $middleName = implode(" ", $arrName); // tên đệm

            // Populate dynamic content
            $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
            $sheet->setCellValue($A, $stt);
            $sheet->setCellValue($B, $mahs);
            $sheet->setCellValue($C, $firstName.' '.$middleName);
            $sheet->setCellValue($D, $lastName);
            $sheet->setCellValue($E, $ngaysinh);
            $sheet->setCellValue($F, $item->masv);
            $sheet->setCellValue($G, $item->tenhp);
            $sheet->setCellValue($H, $item->tinchi);
            $sheet->getStyle('H'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
            $sheet->setCellValue($I, 'CN');
            $sheet->getStyle('I'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);

            $sheet -> getStyle('A11:I'.$row) -> applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                        'color' => ['rgb' => '000000']
                    ],
                ]
            ]);


            $row++;
            $stt++;
        }

        $row++;
        $H = 'H'.$row;
        $I = 'I'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($H.':'.$I);
        $sheet->getStyle('H'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('H'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue($H, 'LẬP BẢNG');
        $sheet -> getStyle('H'.$row) -> applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13,
            ]
        ]);

        $row+=4;
        $H = 'H'.$row;
        $I = 'I'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($H.':'.$I);
        $sheet->getStyle('H'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('H'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue($H, 'Dương Mộng Thu');
        $sheet -> getStyle('H'.$row) -> applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13,
            ]
        ]);


        $sheet->getStyle('A11:I'.$row)->getFont()->setName('Times New Roman');
        $sheet -> getStyle('A13:I'.$row) -> applyFromArray([
            'font' => [
                'size' => 12,
            ]
        ]);

    }
}
