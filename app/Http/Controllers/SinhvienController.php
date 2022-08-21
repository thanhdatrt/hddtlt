<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Imports\ExcelImportSinhvien;
use Maatwebsite\Excel\Facades\Excel;

class SinhvienController extends Controller
{
    public function viewsinhvien(Request $request){
        
        if(isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
            $listsearch = DB::table('sinhvien') -> where('hoten', 'LIKE', '%'.$keyword.'%') ->orWhere('masv', 'LIKE', '%'.$keyword.'%') -> orWhere('malop', 'LIKE', '%'.$keyword.'%')-> paginate(2);
            $result_listsinhvien = view('pages.sinhvien.viewsinhvien') -> with('viewsinhvien', $listsearch);
            $listsearch -> appends($request -> all());
            return view('layout') -> with('pages.sinhvien.viewsinhvien', $result_listsinhvien);
        } 
        else{
            $listsinhvien = DB::table('sinhvien') -> get();
            $result_listsinhvien = view('pages.sinhvien.viewsinhvien') -> with('viewsinhvien', $listsinhvien);
            return view('layout') -> with('pages.sinhvien.viewsinhvien', $result_listsinhvien);
        }
    }

    public function addsinhvien(){
        return view('pages.sinhvien.addsinhvien');
    }

    public static function loaddropdown(){
        $listhe = DB::table('he') -> get();
        $listhtdt = DB::table('htdt') -> get();
        $listlop = DB::table('lop') -> get();
        $listctdt = DB::table('ctdt') -> get();
        $listkhoa = DB::table('khoahoc') -> get();
        $listnganh = DB::table('nganh') -> get();

        return view('pages.sinhvien.addsinhvien') -> with('listhe', $listhe) -> with('listhtdt', $listhtdt) -> with('listlop', $listlop) -> with('listctdt', $listctdt) -> with('listkhoa', $listkhoa) -> with('listnganh', $listnganh);
    }

    public function savesinhvien(Request $request){
        $data = array();
        $temp_masv = $request -> masv;
        $data['masv'] = $request -> masv;
        $data['mahs'] = $request -> mahs;
        $data['mahe'] = $request -> mahe;
        $data['mahtdt'] = $request -> mahtdt;
        $data['hoten'] = $request -> hoten;
        $data['ngaysinh'] = $request -> ngaysinh;
        $data['malop'] = $request -> malop; 
        $data['khoactdt'] = $request -> khoactdt;
        $data['makhoa'] = $request -> makhoa;
        $data['manganh'] = $request -> manganh;
        $data['ghichu'] = $request -> ghichu;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('sinhvien') -> where('masv', $temp_masv) -> first();
        if($result){
            Session::put('message', 'sinh viên đã tồn tại!!!');
            return redirect::to('addsinhvien');
        }
        else if($request -> hoten == ''){
            Session::put('message', 'Tên sinh viên không được để trống!!!');
            return redirect::to('addsinhvien');
        }
        else{
            DB::table('sinhvien') -> insert($data);
            Session::put('message', 'Thêm thành công');
            return redirect::to('addsinhvien');
        }
    }

    // show - hiden sinh vien
    public function hiden_sinhvien($masv){
        DB::table('sinhvien') -> where('masv', $masv) -> update(['status'=> 0]);
        return redirect::to('viewsinhvien');
    }

    public function show_sinhvien($masv){
        DB::table('sinhvien') -> where('masv', $masv) -> update(['status'=> 1]);
        return redirect::to('viewsinhvien');
    }

    public function editsinhvien($masv){
        $listsinhvien = DB::table('sinhvien') -> where('masv', $masv) -> get();
        $listhe = DB::table('he') -> get();
        $listhtdt = DB::table('htdt') -> get();
        $listlop = DB::table('lop') -> get();
        $listctdt = DB::table('ctdt') -> get();
        $listkhoa = DB::table('khoahoc') -> get();
        $listnganh = DB::table('nganh') -> get();
        return view('pages.sinhvien.editsinhvien') -> with('editsinhvien', $listsinhvien) -> with('listhe', $listhe) -> with('listhtdt', $listhtdt) -> with('listlop', $listlop) -> with('listctdt', $listctdt) -> with('listkhoa', $listkhoa) -> with('listnganh', $listnganh);
    }

    public function action_editsinhvien(Request $request, $masv){
        $data = array();
        $data['masv'] = $request -> masv;
        $data['mahs'] = $request -> mahs;
        $data['mahe'] = $request -> mahe;
        $data['mahtdt'] = $request -> mahtdt;
        $data['hoten'] = $request -> hoten;
        $data['ngaysinh'] = $request -> ngaysinh;
        $data['malop'] = $request -> malop; 
        $data['khoactdt'] = $request -> khoactdt;
        $data['makhoa'] = $request -> makhoa;
        $data['manganh'] = $request -> manganh;
        $data['ghichu'] = $request -> ghichu;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> hoten == ''){
            Session::put('message', 'Tên sinh vien không được để trống!!!');
            return redirect::to('editsinhvien');
        }
        else{
            DB::table('sinhvien') -> where('masv', $masv) -> update($data);
            Session::put('message', 'Cập nhật thành công');
            return redirect::to('viewsinhvien');
        }
    }

    public function deletesinhvien($masv){
        DB::table('sinhvien') -> where('masv', $masv) -> delete();
        return redirect::to('viewsinhvien');
    }
    
    public function import_excel(Request $request){
        Excel::import(new ExcelImportSinhvien, $request -> file('filesinhvien') -> store('files'));
        return redirect() -> back();
    }
}
