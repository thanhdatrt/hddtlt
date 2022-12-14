<?php

namespace App\Exports;

use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use Maatwebsite\Excel\Events\BeforeExport;
// use Maatwebsite\Excel\Concerns\RegistersEventListeners;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\FromQuery;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Events\BeforeSheet;
// use Maatwebsite\Excel\Events\AfterSheet;
// use Maatwebsite\Excel\Concerns\FromView;
// use \Maatwebsite\Excel\Sheet;

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
        $nganh = DB::table('nganh') -> where('manganh', $this -> manganh) -> get();
        $htdt = DB::table('htdt') -> where('mahtdt', $this -> mahtdt) -> get();

        $sv_ctdt = DB::table('sinhvien_ctdt') 
            -> where('masv', $this -> masv) 
            -> where('inkhdt', 1) -> orderBy('stt', 'asc') -> get();

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
            $tenhe = $item -> he;
        }


        $title = 'K??? HO???CH ????O T???O NG??NH '.Str::upper($tennganh)."\n".$tenhtdt.' '.Str::upper($tenhe) ;
        // Populate the static cells
        $sheet->setCellValue('A5', $title);

        foreach($sinhvien as $item){
            $sheet->setCellValue('C7', "H??? v?? t??n: ".$item->hoten);
            $sheet->setCellValue('C8', "M?? sinh vi??n: ".$item->masv);
            $sheet->setCellValue('C9', "M?? l???p: ".$item->malop);
            $sheet->setCellValue('G7', $item->ngaysinh);
            $sheet->setCellValue('G8', $item->mahs);
        }

        $row = 13;
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
            $AH = "AH".($row);
            $AI = "AI".($row);
            $AJ = "AJ".($row);
            $AK = "AK".($row);
            $AL = "AL".($row);
            // $AM = "AM".($row);

            // Populate dynamic content
            $sheet->setCellValue($A, $stt);
            $sheet->setCellValue($B, $item->mahp);
            $sheet->setCellValue($C, $item->tenhp);
            $sheet->setCellValue($D, $item->tinchi);
            $sheet->setCellValue($E, $item->tinchilt);
            $sheet->setCellValue($F, $item->sotietlt);
            $sheet->setCellValue($G, $item->tinchith);
            $sheet->setCellValue($H, $item->sotietth);
            $sheet->setCellValue($I, $item->ghichuhp);
            $sheet->setCellValue($AH, $item->tuchon);
            $sheet->setCellValue($AI, $item->sotinchitc);
            $sheet->setCellValue($AJ, $item->mientru);
            $sheet->setCellValue($AK, $item->inkhdt);
            $sheet->setCellValue($AL, $item->ghichu);
            $sheet->setCellValue($AL, $item->ghichu);
            // $sheet->setCellValue($AM, $item->checked);

            $row++;
            $stt++;
        }

        $A = 'A'.$row;
        $C = 'C'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($A.':'.$C);
        $sheet ->setCellValue('A'.$row, 'T???ng c???ng: ');
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet -> getStyle('A'.$row) -> getFont() -> setBold(true);
        $sheet ->setCellValue('D'.$row, $tongtinchi);
        $sheet -> getStyle('D'.$row) -> getFont() -> setBold(true);
        $sheet ->setCellValue('E'.$row, $tongtinchilt);
        $sheet -> getStyle('E'.$row) -> getFont() -> setBold(true);
        $sheet ->setCellValue('F'.$row, $tongsotietlt);
        $sheet -> getStyle('F'.$row) -> getFont() -> setBold(true);
        $sheet ->setCellValue('G'.$row, $tongtinchith);
        $sheet -> getStyle('G'.$row) -> getFont() -> setBold(true);
        $sheet ->setCellValue('H'.$row, $tongsotietth);
        $sheet -> getStyle('H'.$row) -> getFont() -> setBold(true);

        $AL = 'AL'.$row;
        $sheet -> getStyle('A13:'.$AL) -> applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000']
                ],
            ]
        ]);
        
        $row += 2;
        $sheet->setCellValue('C'.$row, 'T???ng s??? t??n ch??? to??n kh??a h???c');
        $sheet -> getStyle('C'.$row) -> getFont() -> setBold(true);
        $sheet->setCellValue('H'.$row, $tongtinchi);
        $sheet -> getStyle('H'.$row) -> getFont() -> setBold(true);
        $sheet->setCellValue('I'.$row, 'T??n ch???');
        $sheet -> getStyle('I'.$row) -> getFont() -> setBold(true);
        $sheet -> getStyle('C'.$row.':I'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->setCellValue('C'.$row, '-C??c h???c ph???n b???t bu???c');
        $sheet->setCellValue('I'.$row, 'T??n ch???');
        $sheet -> getStyle('C'.$row.':I'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->setCellValue('C'.$row, '-T???t nghi???p');
        $sheet->setCellValue('I'.$row, 'T??n ch???');
        $sheet -> getStyle('C'.$row.':I'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->setCellValue('C'.$row, 'Ch??a k??? kh???i ki???n th???c Gi??o d???c th??? ch???t');
        $sheet -> getStyle('C'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);
        $row++;
        $sheet->setCellValue('A'.$row, 'B');
        $sheet->setCellValue('C'.$row, 'H?????NG D???N TH???C HI???N');
        $sheet -> getStyle('A'.$row) -> getFont() -> setBold(true);
        $sheet -> getStyle('C'.$row) -> getFont() -> setBold(true);

        $row++;
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue('A'.$row, '1.');
        $C = 'C'.$row;
        $I = 'I'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($C.':'.$I);
        $sheet->getDelegate()->getRowDimension($row)->setRowHeight(50);
        $sheet->getStyle('C'.$row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('C'.$row)->applyFromArray(['alignment' => ['horizontal' => 'left']]);
        $sheet->getStyle('C'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue('C'.$row, 'Nh???ng h???c ph???n ???????c c??ng nh???n gi?? tr??? chuy???n ?????i k???t qu??? h???c t???p v?? kh???i l?????ng ki???n  th???c ???????c mi???n tr??? khi h???c ch????ng tr??nh ????o t???o ng??nh '.$tennganh.' '.Str::lower($tenhtdt).' '.Str::lower($tenhe).' kh??ng th??? hi???n trong k??? ho???ch ????o t???o n??y.');
        $sheet -> getStyle('C'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue('A'.$row, '2.');
        $C = 'C'.$row;
        $I = 'I'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($C.':'.$I);
        $sheet->setCellValue('C'.$row, 'B???ng ??i???m to??n kh??a h???c ch??? th??? hi???n nh???ng h???c ph???n c?? trong k??? ho???ch ????o t???o.');
        $sheet -> getStyle('C'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $A = 'A'.$row;
        $I = 'I'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($A.':'.$I);
        $sheet->getDelegate()->getRowDimension($row)->setRowHeight(50);
        $sheet->getStyle('A'.$row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'left']]);
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue('A'.$row, '               KT.HI???U TR?????NG                                   KHOA                                  B??? M??N 
              PH?? HI???U TR?????NG');
        $sheet -> getStyle('A'.$row) -> applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13,
            ]
        ]);

        $row += 5;
        $A = 'A'.$row;
        $C = 'C'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($A.':'.$C);
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'left']]);
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue('A'.$row, '                 Nguy???n Minh H??a');

        $sheet -> getStyle('A'.$row) -> applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13,
            ]
        ]);



        $sheet->getStyle('A13:AL'.$row)->getFont()->setName('Times New Roman');
        // $AL = 'AL'.$row;
        $sheet -> getStyle('A13:'.$AL) -> applyFromArray([
            'font' => [
                'size' => 12,
            ]
        ]);
    }
    
}
