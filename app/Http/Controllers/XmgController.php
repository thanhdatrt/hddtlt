<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\Pdf;
use PHPUnit\Framework\Constraint\Count;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;

class XmgController extends Controller
{
    public function dongbo(){
        $listhe = DB::table('he') -> get();
        $listnganh = DB::table('nganh') -> get();
        $listkhoahoc = DB::table('khoahoc') -> get();
        $listkhoactdt1 = DB::table('ctdt') -> get();
        $i = 1;
        $listkhoactdt = array();
        foreach ($listkhoactdt1 as $key => $value) {
            if($listkhoactdt == null){
                $listkhoactdt['khoactdt'.$i] = $value -> khoactdt;
                $i++;
            }
            else if(in_array($value -> khoactdt, $listkhoactdt) == false) {
                $listkhoactdt['khoactdt'.$i] = $value -> khoactdt;
                $i++;
            }
        }

        if(isset($_GET['makhoa']) || isset($_GET['mahe']) || isset($_GET['manganh']) || isset($_GET['khoactdt'])){

            if(isset($_GET['mahe']) && isset($_GET['makhoa']) && isset($_GET['manganh']) && isset($_GET['khoactdt'])){
                $makhoa = $_GET['makhoa'];
                $mahe = $_GET['mahe'];
                $manganh = $_GET['manganh'];
                $khoactdt = $_GET['khoactdt'];

                $sinhvien = DB::table('sinhvien') -> where('makhoa', $makhoa) 
                -> where('mahe', $mahe) 
                -> where('manganh', $manganh) -> where('khoactdt', $khoactdt) -> get();

                $ctdt = DB::table('ctdt') -> where('mahe', $mahe) 
                -> where('manganh', $manganh) 
                -> where('khoactdt', $khoactdt) -> orderBy('stt', 'desc') -> get();

                return view('pages.xetmiengiam.dongbo') 
                -> with('chuongtrinhdt', $ctdt) 
                -> with('sinhvien', $sinhvien) 
                -> with('listhe', $listhe) 
                -> with('listnganh', $listnganh) 
                -> with('listkhoa', $listkhoahoc) 
                -> with('listkhoactdt', $listkhoactdt);
            } else{
                Session::put('message', 'phải chọn tất cả các trường!!!');
                return back();
            }

        } else{
            return view('pages.xetmiengiam.dongbo') -> with('listhe', $listhe) 
                -> with('listnganh', $listnganh) 
                -> with('listkhoa', $listkhoahoc) 
                -> with('listkhoactdt', $listkhoactdt);
        }
    }

    public function savesinhvien_ctdt($masv, $manganh, $mahe, $khoactdt){
        $data = array();
        
        $sinhvien = DB::table('sinhvien') -> where('masv', $masv) -> get();

        $ctdt_monhoc = DB::table('ctdt') 
        -> leftJoin('monhoc', 'monhoc.mahp', '=', 'ctdt.mahp')
        -> whereRaw('monhoc.mahp=ctdt.mahp') 
        -> where('manganh', $manganh) 
        -> where('mahe', $mahe) -> where('khoactdt', $khoactdt) -> get();
        $sv_ctdt = DB::table('sinhvien_ctdt') -> where('masv', $masv) -> first();
        
        if(isset($sv_ctdt)){
            Session::put('message', 'Dữ liệu của sinh viên này đã được đồng bộ');
            return back();
        } else{
            foreach($sinhvien as $index => $value){
                $temp_masv = $value -> masv;
                $temp_mahs = $value -> mahs;
                $temp_mahtdt = $value -> mahtdt;
                $temp_makhoa = $value -> makhoa;
                $temp_khoactdt = $value -> khoactdt;
            }
            foreach($ctdt_monhoc as $ct){
                $data['masv'] = $temp_masv;
                $data['mahs'] = $temp_mahs;
                $data['mahtdt'] = $temp_mahtdt;
                $data['makhoa'] = $temp_makhoa;
                $data['khoactdt'] = $temp_khoactdt;
    
                $data['manganh'] = $ct -> manganh;
                $data['mahe'] = $ct -> mahe;
                $data['mahe'] = $ct -> mahe;
                $data['stt'] = $ct -> stt;
                $data['mahp'] = $ct -> mahp;
                $data['tenhp'] = $ct -> tenhp;
                $data['tinchi'] = $ct -> tinchi;
                $data['tinchilt'] = $ct -> tinchilt;
                $data['sotietlt'] = $ct -> sotietlt; 
                $data['tinchith'] = $ct -> tinchith;
                $data['sotietth'] = $ct -> sotietth;
                $data['ghichuhp'] = $ct -> ghichuhp; 
                $data['tuchon'] = $ct -> tuchon;
                $data['sotinchitc'] = $ct -> sotinchitc;
                $data['mientru'] = 0;
                $data['inkhdt'] = 0;
                $data['status'] = 1;
                $data['create_at'] = new dateTime('now');
    
                DB::table('sinhvien_ctdt') -> insert($data);
            }
            Session::put('message', 'Đồng bộ thành công');
            return back();
        }
    }

    public function xetmientruhp(){
        $sinhvien_ctdt = DB::table('sinhvien_ctdt') -> get();

        $listmasv = array();
        $listhe = array();
        $listkhoa = array();
        $listnganh = array();
        $listkhoactdt = array();
        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listmasv == null){
                $listmasv['masv'.$i] = $value -> masv;
                $i++;
            }
            else if(in_array($value -> masv, $listmasv) == false) {
                $listmasv['masv'.$i] = $value -> masv;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listhe == null){
                $listhe['masv'.$i] = $value -> mahe;
                $i++;
            }
            else if(in_array($value -> mahe, $listhe) == false) {
                $listhe['mahe'.$i] = $value -> mahe;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listkhoa == null){
                $listkhoa['makhoa'.$i] = $value -> makhoa;
                $i++;
            }
            else if(in_array($value -> makhoa, $listkhoa) == false) {
                $listkhoa['makhoa'.$i] = $value -> makhoa;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listnganh == null){
                $listnganh['manganh'.$i] = $value -> manganh;
                $i++;
            }
            else if(in_array($value -> manganh, $listnganh) == false) {
                $listnganh['manganh'.$i] = $value -> manganh;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listkhoactdt == null){
                $listkhoactdt['khoactdt'.$i] = $value -> khoactdt;
                $i++;
            }
            else if(in_array($value -> khoactdt, $listkhoactdt) == false) {
                $listkhoactdt['khoactdt'.$i] = $value -> khoactdt;
                $i++;
            }
        }

        return view('pages.xetmiengiam.xetmientruhp') -> with('listmasv', $listmasv) -> with('listhe', $listhe) -> with('listkhoa', $listkhoa) -> with('listnganh', $listnganh) -> with('listkhoactdt', $listkhoactdt);
    }

    public function filterdata(){
        $sinhvien_ctdt = DB::table('sinhvien_ctdt') -> get();

        $listmasv = array();
        $listhe = array();
        $listkhoa = array();
        $listnganh = array();
        $listkhoactdt = array();
        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listmasv == null){
                $listmasv['masv'.$i] = $value -> masv;
                $i++;
            }
            else if(in_array($value -> masv, $listmasv) == false) {
                $listmasv['masv'.$i] = $value -> masv;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listhe == null){
                $listhe['masv'.$i] = $value -> mahe;
                $i++;
            }
            else if(in_array($value -> mahe, $listhe) == false) {
                $listhe['mahe'.$i] = $value -> mahe;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listkhoa == null){
                $listkhoa['makhoa'.$i] = $value -> makhoa;
                $i++;
            }
            else if(in_array($value -> makhoa, $listkhoa) == false) {
                $listkhoa['makhoa'.$i] = $value -> makhoa;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listnganh == null){
                $listnganh['manganh'.$i] = $value -> manganh;
                $i++;
            }
            else if(in_array($value -> manganh, $listnganh) == false) {
                $listnganh['manganh'.$i] = $value -> manganh;
                $i++;
            }
        }

        $i = 1;
        foreach ($sinhvien_ctdt as $key => $value) {
            if($listkhoactdt == null){
                $listkhoactdt['khoactdt'.$i] = $value -> khoactdt;
                $i++;
            }
            else if(in_array($value -> khoactdt, $listkhoactdt) == false) {
                $listkhoactdt['khoactdt'.$i] = $value -> khoactdt;
                $i++;
            }
        }

        if(isset($_GET['mahe']) && isset($_GET['makhoa']) && isset($_GET['manganh']) && isset($_GET['khoactdt'])){

            $makhoa = $_GET['makhoa'];
            $mahe = $_GET['mahe'];
            $manganh = $_GET['manganh'];
            $khoactdt = $_GET['khoactdt'];
            $masv = $_GET['masv'];

            $htdt = DB::table('sinhvien') -> where('masv', $masv) -> get();
            
            foreach ($htdt as $item){
                $mahtdt     = $item -> mahtdt;
                $mahe       = $item -> mahe;
                $makhoa     = $item -> makhoa;
            }

            $sv_ctdt = DB::table('sinhvien_ctdt') 
                -> where('makhoa', $makhoa) 
                -> where('mahe', $mahe) 
                -> where('manganh', $manganh) 
                -> where('khoactdt', $khoactdt) 
                -> where('masv', $masv) -> orderBy('stt', 'asc')-> get();
            // $sv_ctdt -> appends(['sort' => 'votes']);
            return view('pages.xetmiengiam.xetmientruhp') -> with('sv_ctdt', $sv_ctdt) 
                -> with('masv', $masv) -> with('manganh', $manganh) -> with('mahtdt', $mahtdt) 
                -> with('mahe', $mahe) -> with('makhoa', $makhoa) -> with('khoactdt', $khoactdt)
                -> with('listmasv', $listmasv) 
                -> with('listhe', $listhe) 
                -> with('listkhoa', $listkhoa) 
                -> with('listnganh', $listnganh) 
                -> with('listkhoactdt', $listkhoactdt);

        } else{
            Session::put('message', 'phải chọn tất cả các trường!!!');
            return back();
        }
    }

    public function save_miengiam(Request $request, $mahp, $masv){
        $data = array();
        if(substr($request -> $mahp, 0, 7) == 'mientru'){
            $data['mientru'] = 1;
            $data['inkhdt'] = 0;
        } else {
            $data['mientru'] = 0;
            $data['inkhdt'] = 1;
        }
        // $numbers = filter_var($request -> ghichu, FILTER_SANITIZE_NUMBER_INT);
        $data['ghichu'] = $request -> ghichu;
        DB::table('sinhvien_ctdt') -> where('mahp', $mahp) -> where('masv', $masv) -> update($data);
        return redirect() -> back();
    }

    public function inkhdt($masv, $manganh, $mahtdt){
        $sinhvien = DB::table('sinhvien') -> where('masv', $masv) -> get();
        $sv_ctdt = DB::table('sinhvien_ctdt') -> where('masv', $masv) -> get();
        $nganh = DB::table('nganh') -> where('manganh', $manganh) -> get();
        $htdt = DB::table('htdt') -> where('mahtdt', $mahtdt) -> get();
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
            $tongtinchi += $item -> tinchi;
            $tongtinchilt += $item -> tinchilt;
            $tongsotietlt += $item -> sotietlt;
            $tongsotietth += $item -> sotietth;
            $tongtinchith += $item -> tinchith;
        }
        
        $pdf = PDF::loadView('pages.xetmiengiam.printkhdt', compact('sinhvien', 'sv_ctdt', 'tennganh', 'tenhtdt', 'tongtinchi', 'tongtinchilt', 'tongsotietlt', 'tongtinchith', 'tongsotietth',));

        return $pdf -> download('khdt.pdf');
    }

    public function inkhdt_excel(Request $request, $masv, $manganh, $mahtdt){
        $sinhvien = DB::table('sinhvien') -> where('masv', $masv) -> get();
        $sv_ctdt = DB::table('sinhvien_ctdt') -> where('masv', $masv) -> get();
        $nganh = DB::table('nganh') -> where('manganh', $manganh) -> get();
        $htdt = DB::table('htdt') -> where('mahtdt', $mahtdt) -> get();
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
            $tongtinchi += $item -> tinchi;
            $tongtinchilt += $item -> tinchilt;
            $tongsotietlt += $item -> sotietlt;
            $tongsotietth += $item -> sotietth;
            $tongtinchith += $item -> tinchith;
        }

        
    }

    public function ingtcd($masv, $manganh, $mahtdt, $mahe, $makhoa){
        $ctdt_sinhvien = DB::table('sinhvien_ctdt') -> where('masv', $masv) -> get();
        $sinhvien = DB::table('sinhvien') -> where('masv', $masv) -> get();
        $nganh = DB::table('nganh') -> where('manganh', $manganh) -> get();
        $htdt = DB::table('htdt') -> where('mahtdt', $mahtdt) -> get();
        $he = DB::table('he') -> where('mahe', $mahe) -> get();
        $khoa = DB::table('khoahoc') -> where('makhoa', $makhoa) -> get();
            foreach($nganh as $item){
                $tennganh = $item -> tennganh;
            }
            foreach($htdt as $item){
                $tenhtdt = $item -> tenhtdt;
            }
            foreach($he as $item){
                $tenhe = $item -> he;
            }
            foreach($khoa as $item){
                $tenkhoa = $item -> tenkhoa;
            }
            foreach($sinhvien as $item){
                $hoten = $item -> hoten;
                $ngaysinh = $item -> ngaysinh;
                $mahs = $item -> mahs;
            }

        $pdf = PDF::loadView('pages.xetmiengiam.printgtcd', compact('ctdt_sinhvien', 'tennganh', 'tenhtdt', 'tenhe', 'tenkhoa', 'hoten', 'ngaysinh', 'mahs')) -> setPaper([0,0,595.27,841.88], 'landscape');
        
        return $pdf -> download('gtcd.pdf');
    }

    public function capnhat(Request $request) {
        $checkbox       = $request -> status_checkbox;
        $mahp           = $request -> mahp;
        $tuchon         = $request -> tuchon;
        $tinchi         = $request -> tinchi;
        $sotinchituchon = $request -> sotinchitc;
        $masv           = $request -> masv;
        // xoa phan tu thua trong mang
        for ($i=0; $i < count($checkbox); $i++) { 
            if($checkbox[$i] == 1){
                unset($checkbox[$i - 1]);
            }
        }
        $mientru = array_values($checkbox);

        for ($i=0; $i < count($mahp); $i++) { 
            if($mientru[$i] == 1){
                $data = [
                    'mientru'     => 1,
                    'inkhdt'      => 0,
                ];
            } else {
                $data = [
                    'mientru'     => 0,
                    'inkhdt'      => 1,
                ];
            }
            DB::table('sinhvien_ctdt') -> where('masv', $masv) -> where('mahp', $mahp[$i]) -> update($data);
        }

        return back();
    }
}
