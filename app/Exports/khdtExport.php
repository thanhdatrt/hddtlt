<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use \Maatwebsite\Excel\Sheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $sv_ctdt = DB::table('sinhvien_ctdt') 
        -> where('masv', $this -> masv) 
        -> where('inkhdt', 1) -> orwhere('role', 0) -> where('masv', $this -> masv) -> get();
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
            $tenhe = $item -> he;
        }


        $title = 'KẾ HOẠCH ĐÀO TẠO NGÀNH '.Str::upper($tennganh)."\n".$tenhtdt.' '.Str::upper($tenhe) ;
        // Populate the static cells
        $sheet->setCellValue('A5', $title);

        foreach($sinhvien as $item){
            $sheet->setCellValue('C7', "Họ và tên: ".$item->hoten);
            $sheet->setCellValue('C8', "Mã sinh viên: ".$item->masv);
            $sheet->setCellValue('C9', "Mã lớp: ".$item->malop);
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

            $row++;
            $stt++;
        }

        $A = 'A'.$row;
        $C = 'C'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($A.':'.$C);
        $sheet ->setCellValue('A'.$row, 'Tổng cộng: ');
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
        $sheet->setCellValue('C'.$row, 'Tổng số tín chỉ toàn khóa học');
        $sheet -> getStyle('C'.$row) -> getFont() -> setBold(true);
        $sheet->setCellValue('H'.$row, $tongtinchi);
        $sheet -> getStyle('H'.$row) -> getFont() -> setBold(true);
        $sheet->setCellValue('I'.$row, 'Tín chỉ');
        $sheet -> getStyle('I'.$row) -> getFont() -> setBold(true);
        $sheet -> getStyle('C'.$row.':I'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->setCellValue('C'.$row, '-Các học phần bắt buộc');
        $sheet->setCellValue('I'.$row, 'Tín chỉ');
        $sheet -> getStyle('C'.$row.':I'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->setCellValue('C'.$row, '-Tốt nghiệp');
        $sheet->setCellValue('I'.$row, 'Tín chỉ');
        $sheet -> getStyle('C'.$row.':I'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->setCellValue('C'.$row, 'Chưa kể khối kiến thức Giáo dục thể chất');
        $sheet -> getStyle('C'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);
        $row++;
        $sheet->setCellValue('A'.$row, 'B');
        $sheet->setCellValue('C'.$row, 'HƯỚNG DẪN THỰC HIỆN');
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
        $sheet->setCellValue('C'.$row, 'Những học phần được công nhận giá trị chuyển đổi kết quả học tập và khối lượng kiến  thức được miễn trừ khi học chương trình đào tạo ngành '.$tennganh.' '.Str::lower($tenhtdt).' '.Str::lower($tenhe).' không thể hiện trong kế hoạch đào tạo này.');
        $sheet -> getStyle('C'.$row) -> applyFromArray([
            'font' => [
                'size' => 13,
            ]
        ]);

        $row++;
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['horizontal' => 'center']]);
        $sheet->getStyle('A'.$row)->applyFromArray(['alignment' => ['vertical' => 'top']]);
        $sheet->setCellValue('A'.$row, '1.');
        $C = 'C'.$row;
        $I = 'I'.$row;
        // gop cot
        $sheet->getDelegate()->mergeCells($C.':'.$I);
        $sheet->setCellValue('C'.$row, 'Bảng điểm toàn khóa học chỉ thể hiện những học phần có trong kế hoạch đào tạo.');
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
        $sheet->setCellValue('A'.$row, '               KT.HIỆU TRƯỞNG                                   KHOA                                  BỘ MÔN 
              PHÓ HIỆU TRƯỞNG');
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
        $sheet->setCellValue('A'.$row, '                 Nguyễn Minh Hòa');

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
