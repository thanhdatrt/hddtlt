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
use App\Models\XmgModel;

class XmgController extends Controller
{
    public function AuthLogin(){
        $id = Session::get('id');
        if($id){
            return Redirect::to('home');
        }
        else{
            return Redirect::to('/') -> send();
        }
    }

    public function dongbo(){
        $this -> AuthLogin();

        $listhe = DB::table('he') -> get();
        $listnganh = DB::table('nganh') -> get();
        $listkhoahoc = DB::table('khoahoc') -> get();
        $listkhoactdt1 = DB::table('ctdt') -> get();
        $i = 1;
        $listkhoactdt = array();

        // lay du lieu khong trung nhau
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

                $sinhvien = DB::table('sinhvien') 
                -> where('makhoa', $makhoa) 
                -> where('mahe', $mahe) 
                -> where('manganh', $manganh) 
                -> where('khoactdt', $khoactdt) -> get();

                $ctdt = DB::table('ctdt') -> where('mahe', $mahe) 
                -> where('manganh', $manganh) 
                -> where('khoactdt', $khoactdt) 
                -> orderBy('stt', 'asc') -> get();

                return view('pages.xetmiengiam.dongbo') 
                    -> with('chuongtrinhdt', $ctdt) 
                    -> with('sinhvien', $sinhvien) 
                    -> with('listhe', $listhe) 
                    -> with('listnganh', $listnganh) 
                    -> with('listkhoa', $listkhoahoc) 
                    -> with('listkhoactdt', $listkhoactdt)
                    -> with('makhoa', $makhoa)
                    -> with('mahe', $mahe)
                    -> with('manganh', $manganh)
                    -> with('khoactdt', $khoactdt);
            } else{
                Session::put('message', 'ph???i ch???n t???t c??? c??c tr?????ng!!!');
                return back();
            }

        } else{
            return view('pages.xetmiengiam.dongbo') 
                -> with('listhe', $listhe) 
                -> with('listnganh', $listnganh) 
                -> with('listkhoa', $listkhoahoc) 
                -> with('listkhoactdt', $listkhoactdt);
        }
    }

    public function savesinhvien_ctdt($masv, $manganh, $mahe, $khoactdt){
        $this -> AuthLogin();

        $data = array();
        
        $sinhvien = DB::table('sinhvien') -> where('masv', $masv) -> get();

        $ctdt_monhoc = DB::table('ctdt') 
            -> leftJoin('monhoc', 'monhoc.mahp', '=', 'ctdt.mahp')
            -> whereRaw('monhoc.mahp=ctdt.mahp') 
            -> where('manganh', $manganh) 
            -> where('mahe', $mahe) -> where('khoactdt', $khoactdt) -> get();

        $sv_ctdt = DB::table('sinhvien_ctdt') -> where('masv', $masv) -> first();
        
        if(isset($sv_ctdt)){
            Session::put('message', 'D??? li???u c???a sinh vi??n n??y ???? ???????c ?????ng b???');
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
                $data['checked'] = 0;
                $data['create_at'] = new dateTime('now');
    
                DB::table('sinhvien_ctdt') -> insert($data);
            }
            $data = null;
            $data = [
                'role' => 1,
            ];

            DB::table('sinhvien') -> where('masv', $masv) -> update($data);
            Session::put('message', '?????ng b??? th??nh c??ng');
            return back();
        }
    }

    public function xetmientruhp(){
        $this -> AuthLogin();

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
        $this -> AuthLogin();

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
            Session::put('message', 'ph???i ch???n t???t c??? c??c tr?????ng!!!');
            return back();
        }
    }

    public function inkhdt($masv, $manganh, $mahtdt){
        $this -> AuthLogin();

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
        
        $pdf = PDF::loadView('pages.xetmiengiam.printkhdt', 
        compact('sinhvien', 'sv_ctdt', 'tennganh',
                'tenhtdt', 'tongtinchi', 'tongtinchilt', 
                'tongsotietlt', 'tongtinchith', 'tongsotietth',));

        return $pdf -> download('khdt.pdf');
    }

    public function ingtcd($masv, $manganh, $mahtdt, $mahe, $makhoa){
        $this -> AuthLogin();

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
        $this -> AuthLogin();

        $checkbox       = $request -> status_checkbox;
        $mahp           = $request -> mahp;
        $tuchon         = $request -> tuchon;
        $tinchi         = $request -> tinchi;
        $tinchitc       = $request -> sotinchitc;
        $masv           = $request -> masv;
        
        $i = 0;
        foreach($checkbox as $item){
            if($item == 1){
                unset($checkbox[$i - 1]);
            }
            $i++;
        }

        // get value of checkbox 
        $mientru = array_values($checkbox);

        $result_tuchon = null;
        $result_tctuchon = null;
        $result_tinchi = null;

        for($i=0; $i < count($mahp); $i++) {
            if($tuchon[$i] == null){
                $data = array();
                // c???p nh???t d?? gi?? tr??? m??n kh??ng t??? ch???n
                if($result_tuchon != null){
                    if($result_tinchi < $result_tctuchon){
                        $minus = $result_tctuchon - $result_tinchi;
                        $ghichu = 'Ch???n '.$minus.' tc';
                        $data['ghichu'] = $ghichu;
                        $data['mientru'] = 0;
                        $data['inkhdt'] = 1;

                        DB::table('sinhvien_ctdt') 
                        -> where('tuchon', $result_tuchon)  
                        -> where('inkhdt', 0)
                        -> where('checked', 0) 
                        -> update($data);

                    } else if($result_tinchi >= $result_tctuchon){
                        $data['mientru'] = 1;
                        $data['inkhdt'] = 0;
                        $data['ghichu'] = '';

                        DB::table('sinhvien_ctdt') 
                        -> where('tuchon', $result_tuchon) 
                        -> update($data);
                    }
                    $result_tuchon = null;
                    $result_tctuchon = null;
                    $result_tinchi = null;

                } else {
                    if($mientru[$i] == 1){
                        $data = [
                            'mientru'       => 1,
                            'inkhdt'        => 0,
                            'checked'       => 1,
                        ];
                    } else {
                        $data = [
                            'mientru'     => 0,
                            'inkhdt'      => 1,
                            'checked'       => 0,
                        ];
                    }
                    DB::table('sinhvien_ctdt') -> where('masv', $masv) -> where('mahp', $mahp[$i]) -> update($data);
                }
            } else {
                // gia tri tu chon
                if($result_tuchon == null){
                    $result_tuchon = $tuchon[$i];
                    $result_tctuchon = $tinchitc[$i];
                    $data = null;
                    if($mientru[$i] == 1){
                        $result_tinchi = $tinchi[$i];  
                        $data = [
                            'checked'       => 1,
                            'mientru'       => 1,
                            'inkhdt'        => 0,
                        ];
                    } else {
                        $data = [
                            'checked'       => 0,
                        ];
                    }
                    DB::table('sinhvien_ctdt') -> where('masv', $masv) -> where('mahp', $mahp[$i]) -> update($data);

                } else if($result_tuchon == $tuchon[$i]){
                    $data = null;
                    if($mientru[$i] == 1){
                        $result_tinchi += $tinchi[$i];  
                        $data = [
                            'checked'     => 1,
                            'mientru'       => 1,
                            'inkhdt'        => 0,
                        ];
                    } else {
                        $data = [
                            'checked'       => 0,
                        ];
                    }
                    DB::table('sinhvien_ctdt') -> where('masv', $masv) -> where('mahp', $mahp[$i]) -> update($data);
                } else {
                    $data = null;
                    if($result_tinchi < $result_tctuchon){
                        $minus = $result_tctuchon - $result_tinchi;
                        $ghichu = 'Ch???n '.$minus.' tc';
                        $data['ghichu'] = $ghichu;
                        $data['mientru'] = 0;
                        $data['inkhdt'] = 1;

                        DB::table('sinhvien_ctdt') 
                        -> where('tuchon', $result_tuchon) 
                        -> where('inkhdt', 0)
                        -> where('checked', 0) 
                        -> update($data);

                    } else if($result_tinchi >= $result_tctuchon){
                        $data['mientru'] = 1;
                        $data['inkhdt'] = 0;
                        $data['ghichu'] = '';

                        DB::table('sinhvien_ctdt') 
                        -> where('tuchon', $result_tuchon) 
                        -> update($data);
                    }


                    // nhom moi
                    $result_tuchon = null;
                    $result_tctuchon = null;
                    $result_tinchi = 0;
                    $data = null;
                    $result_tuchon = $tuchon[$i];
                    $result_tctuchon = $tinchitc[$i];
                    if($mientru[$i] == 1){
                        $result_tinchi = $tinchi[$i];  
                        $data = [
                            'checked'       => 1,
                        ];
                    } else {
                        $data = [
                            'checked'       => 0,
                        ];
                    }
                    DB::table('sinhvien_ctdt') -> where('masv', $masv) -> where('mahp', $mahp[$i]) -> update($data);
                }
            }
        }
        
        return back();
    }

    public function dadongbo(){
        $this -> AuthLogin();

        $sinhvien = DB::table('sinhvien') -> where('role', 1) -> get();
        return view('pages.xetmiengiam.dadongbo') -> with('sinhvien', $sinhvien);
    }

    public function huydongbo($masv, $manganh){
        $this -> AuthLogin();

        $data = array();
        $data['role'] = 0;
        try {
            DB::table('sinhvien') -> where('masv', $masv) -> where('manganh', $manganh) -> update($data);
            DB::table('sinhvien_ctdt') -> where('masv', $masv) -> where('manganh', $manganh) -> delete();
            Session::put('message', '???? h???y ?????ng b??? m?? sinh vi??n '.$masv.'!!!');
        } catch (\Throwable $th) {
            Session::put('message', 'L???i: '.$th.'!!!');
            
        }
        return back();
    }

    

}
