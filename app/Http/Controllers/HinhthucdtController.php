<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HinhthucdtController extends Controller
{
    public function viewhtdt(){
        $listhtdt = DB::table('htdt') -> get();
        $result_listhtdt = view('pages.htdt.viewhtdt') -> with('viewhtdt', $listhtdt);
        return view('layout') -> with('pages.htdt.viewhtdt', $result_listhtdt);
    }

    public function addhtdt(){
        return view('pages.htdt.addhtdt');
    }

    // action save mon hoc
    public function savehtdt(Request $request){
        $data = array();
        $temp_mahtdt = $request -> mahtdt;
        $data['mahtdt'] = $request -> mahtdt;
        $data['tenhtdt'] = $request -> tenhtdt;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('htdt') -> where('mahtdt', $temp_mahtdt) -> first();
        if($result){
            Session::put('message', 'Hình thức đào tạo đã tồn tại!!!');
            return redirect::to('addhtdt');
        }
        else if($request -> tenhtdt == ''){
            Session::put('message', 'Tên hình thức đào tạo không được để trống!!!');
            return redirect::to('addhtdt');
        }
        else{
            DB::table('htdt') -> insert($data);
            Session::put('message', 'Thêm thành công');
            return redirect::to('addhtdt');
        }
    }

    //search
    public function search(){
        
    }

    // show - hiden mon hoc
    public function hiden_htdt($mahtdt){
        DB::table('htdt') -> where('mahtdt', $mahtdt) -> update(['status'=> 0]);
        return redirect::to('viewhtdt');
    }

    public function show_htdt($mahtdt){
        DB::table('htdt') -> where('mahtdt', $mahtdt) -> update(['status'=> 1]);
        return redirect::to('viewhtdt');
    }

    // GET edit mon hoc
    public function edithtdt($mahtdt){
        $listhtdt = DB::table('htdt') -> where('mahtdt', $mahtdt) -> get();
        $result_edithtdt = view('pages.htdt.edithtdt') -> with('edithtdt', $listhtdt);
        return view('layout') -> with('pages.htdt.edithtdt', $result_edithtdt);
        return redirect::to('edithtdt');

    }
    // POST edit mon hoc
    public function action_edithtdt(Request $request, $mahtdt){
        $data = array();
        $data['htdt'] = $request -> tenhtdt;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> tenhtdt == ''){
            Session::put('message', 'Tên hình thức đào tạo không được để trống!!!');
            return redirect::to('edithtdt');
        }
        else{
            DB::table('htdt') -> where('mahtdt', $mahtdt) -> update($data);
            Session::put('message', 'Cập nhật thành công');
            return redirect::to('viewhtdt');
        }
    }

    // delete mon hoc
    public function deletehtdt($mahtdt){
        DB::table('htdt') -> where('mahtdt', $mahtdt) -> delete();
        return redirect::to('viewhtdt');
    }
}
