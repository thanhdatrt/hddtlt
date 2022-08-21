<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PharIo\Manifest\Url;
use App\Http\Controllers\timestamp;

class KhoahocController extends Controller
{
    public function viewkhoahoc(){
        $listkhoahoc = DB::table('khoahoc') -> get();
        $result_listkhoahoc = view('pages.khoahoc.viewkhoahoc') -> with('viewkhoahoc', $listkhoahoc);
        return view('layout') -> with('pages.khoahoc.viewkhoahoc', $result_listkhoahoc);
    }

    public function addkhoahoc(){
        return view('pages.khoahoc.addkhoahoc');
    }

    // action save mon hoc
    public function savekhoahoc(Request $request){
        $data = array();
        $temp_makhoahoc = $request -> makhoa;
        $data['makhoa'] = $request -> makhoa;
        $data['tenkhoa'] = $request -> tenkhoa;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('khoahoc') -> where('makhoa', $temp_makhoahoc) -> first();
        if($result){
            Session::put('message', 'Khóa đã tồn tại!!!');
            return redirect::to('addkhoahoc');
        }
        else if($request -> tenkhoa == ''){
            Session::put('message', 'Tên khóa học không được để trống!!!');
            return redirect::to('addkhoahoc');
        }
        else{
            DB::table('khoahoc') -> insert($data);
            Session::put('message', 'Thêm khóa học thành công');
            return redirect::to('addkhoahoc');
        }
    }

    //search
    public function search(){
        
    }

    // show - hiden mon hoc
    public function hiden_khoahoc($makhoahoc){
        DB::table('khoahoc') -> where('makhoa', $makhoahoc) -> update(['status'=> 0]);
        return redirect::to('viewkhoahoc');
    }

    public function show_khoahoc($makhoahoc){
        DB::table('khoahoc') -> where('makhoa', $makhoahoc) -> update(['status'=> 1]);
        return redirect::to('viewkhoahoc');
    }

    // GET edit mon hoc
    public function editkhoahoc($makhoahoc){
        $listkhoahoc = DB::table('khoahoc') -> where('makhoa', $makhoahoc) -> get();
        $result_editkhoahoc = view('pages.khoahoc.editkhoahoc') -> with('editkhoahoc', $listkhoahoc);
        return view('layout') -> with('pages.khoahoc.editkhoahoc', $result_editkhoahoc);
        return redirect::to('editkhoahoc');

    }
    // POST edit mon hoc
    public function action_editkhoahoc(Request $request, $makhoahoc){
        $data = array();
        $data['khoahoc'] = $request -> tenkhoahoc;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> tenkhoahoc == ''){
            Session::put('message', 'Tên khóa không được để trống!!!');
            return redirect::to('editkhoahoc');
        }
        else{
            DB::table('khoahoc') -> where('makhoa', $makhoahoc) -> update($data);
            Session::put('message', 'Cập nhật thành công');
            return redirect::to('viewkhoahoc');
        }
    }

    // delete mon hoc
    public function deletekhoahoc($makhoahoc){
        DB::table('khoahoc') -> where('makhoa', $makhoahoc) -> delete();
        return redirect::to('viewkhoahoc');
    }
}
