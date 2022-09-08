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

    public function __construct($masv, $manganh, $mahtdt, $mahe, $makhoa, $khoactdt){
        $this -> masv = $masv;
        $this -> manganh = $manganh;
        $this -> mahtdt = $mahtdt;
        $this -> mahe = $mahe;
        $this -> mahtdt = $mahtdt;
        $this -> makhoa = $makhoa;
        $this -> khoactdt = $khoactdt;
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
        $nganh = DB::table('nganh') -> where('manganh', $this->manganh) -> get();
        $htdt = DB::table('htdt') -> where('mahtdt', $this->mahtdt) -> get();
        $he = DB::table('he') -> where('mahe', $this->mahe) -> get();

        $sv_ctdt = DB::table('sinhvien_ctdt') -> join('sinhvien', 'sinhvien.masv', '=', 'sinhvien_ctdt.masv')
        -> where('sinhvien_ctdt.manganh', $this -> manganh)
        -> where('sinhvien_ctdt.khoactdt', $this ->khoactdt)
        -> where('sinhvien_ctdt.mahe', $this -> mahe)
        -> where('sinhvien_ctdt.makhoa', $this -> makhoa)
        -> where('mientru', 1) -> where('checked', 1) 
        -> orderBy('sinhvien_ctdt.mahs', 'asc')
        -> orderBy('sinhvien_ctdt.stt', 'asc') -> get();

        foreach($nganh as $item){
            $tennganh = $item -> tennganh;
        }
        foreach($htdt as $item){
            $tenhtdt    = $item -> tenhtdt;
        }
        foreach($he as $item){
            $tenhe      = $item -> he;
        }


        $temp = Str::lower($tenhtdt);
        $temp1 = Str::ucfirst($temp);
        $sheet->setCellValue('C5', $tennganh);
        $bac = $temp1.' '.$tenhe;
        $sheet->setCellValue('C6', $bac);
        

        $row = 11;
        $stt = 1;
        foreach($sv_ctdt as $item){
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

            $fullname = $item -> hoten;
            $arrName = explode(" ", $fullname);

            $firstName = array_shift($arrName); // họ
            $lastName = array_pop($arrName); // tên
            $middleName = implode(" ", $arrName); // tên đệm

            // Populate dynamic content
            $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
            $sheet->setCellValue($A, $stt);
            $sheet->setCellValue($B, $item -> mahs);
            $sheet->setCellValue($C, $firstName.' '.$middleName);
            $sheet->setCellValue($D, $lastName);
            $sheet->setCellValue($E, $item -> ngaysinh);
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
        $sheet -> getStyle('A11:I'.$row) -> applyFromArray([
            'font' => [
                'size' => 12,
            ]
        ]);

    }
}
