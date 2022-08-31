<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Imports\ExcelImportCtdt;
use Maatwebsite\Excel\Facades\Excel;

class CtdtController extends Controller
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

    public function viewctdt(Request $request){
        $this -> AuthLogin();
        
        if(isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
            $listsearch = DB::table('ctdt') -> Where('mahp', 'LIKE', '%'.$keyword.'%') -> paginate(2);
            $result_listctdt = view('pages.ctdt.viewctdt') -> with('viewctdt', $listsearch);
            $listsearch -> appends($request -> all());
            return view('layout') -> with('pages.ctdt.viewctdt', $result_listctdt);
        } 
        else{
            $listctdt = DB::table('ctdt') -> orderBy('stt', 'asc') -> get();
            $result_listctdt = view('pages.ctdt.viewctdt') -> with('viewctdt', $listctdt);
            return view('layout') -> with('pages.ctdt.viewctdt', $result_listctdt);
        }
    }

    public function addctdt(){
        $this -> AuthLogin();

        return view('pages.ctdt.addctdt');
    }

    public function loaddropdownctdt(){
        $this -> AuthLogin();

        $listhe = DB::table('he') -> get();
        $listmonhoc = DB::table('monhoc') -> get();
        $listnganh = DB::table('nganh') -> get();

        return view('pages.ctdt.addctdt') -> with('listhe', $listhe) -> with('listnganh', $listnganh) -> with('listmonhoc', $listmonhoc);
    }

    // action save mon hoc
    public function savectdt(Request $request){
        $this -> AuthLogin();
        $data = array();
        $temp_mahp = $request -> mahp;
        $data['mahp'] = $request -> mahp;
        $data['manganh'] = $request -> manganh;
        $data['mahe'] = $request -> mahe;
        $data['khoactdt'] = $request -> khoactdt;
        $data['tuchon'] = $request -> tuchon;
        $data['sotinchitc'] = $request -> sotinchitc;

        $result_count = DB::table('ctdt') -> get();
        $count = count($result_count);
        $data['stt'] = $count + 1;
        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('ctdt') -> where('mahp', $temp_mahp) -> first();
        if($result){
            Session::put('message', 'Học phần đã tồn tại!!!');
            return redirect::to('addctdt');
        }
        else if($request -> mahp == ''){
            Session::put('message', 'Chưa chọn học phần không được để trống!!!');
            return redirect::to('addctdt');
        }
        else{
            DB::table('ctdt') -> insert($data);
            Session::put('message', 'Thêm thành công');
            return redirect::to('addctdt');
        }
    }

    // show - hiden mon hoc
    public function hiden_ctdt($mahp){
        $this -> AuthLogin();
        DB::table('ctdt') -> where('mahp', $mahp) -> update(['status'=> 0]);
        return redirect::to('viewctdt');
    }

    public function show_ctdt($mahp){
        $this -> AuthLogin();
        DB::table('ctdt') -> where('mahp', $mahp) -> update(['status'=> 1]);
        return redirect::to('viewctdt');
    }

    // GET edit mon hoc
    public function editctdt($mahp){
        $this -> AuthLogin();
        $listctdt = DB::table('ctdt') -> where('mahp', $mahp) -> get();
        $listhe = DB::table('he') -> get();
        $listmonhoc = DB::table('monhoc') -> get();
        $listnganh = DB::table('nganh') -> get();

        return view('pages.ctdt.editctdt') -> with('editctdt', $listctdt) -> with('listhe', $listhe) -> with('listnganh', $listnganh) -> with('listmonhoc', $listmonhoc);
    }
    // POST edit mon hoc
    public function action_editctdt(Request $request, $mahp){
        $this -> AuthLogin();
        $data = array();
        $data['mahp'] = $mahp;
        $data['manganh'] = $request -> manganh;
        $data['mahe'] = $request -> mahe;
        $data['khoactdt'] = $request -> khoactdt;
        $data['tuchon'] = $request -> tuchon;
        $data['sotinchitc'] = $request -> sotinchitc;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> mahp == ''){
            Session::put('message', 'Học phần không được để trống!!!');
            return redirect::to('editctdt');
        }
        else{
            DB::table('ctdt') -> where('mahp', $mahp) -> update($data);
            Session::put('message', 'Cập nhật thành công');
            return redirect::to('viewctdt');
        }
    }

    // delete mon hoc
    public function deletectdt($mahp){
        $this -> AuthLogin();
        DB::table('ctdt') -> where('mahp', $mahp) -> delete();
        return redirect::to('viewctdt');
    }

    // import excel
    public function import_excel(Request $request){
        $this -> AuthLogin();
        Excel::import(new ExcelImportCtdt(2), $request -> file('filectdt') -> store('files'));
        return redirect() -> back();
    }
}
