<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NganhController extends Controller
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

    public function viewnganh(){
        $this -> AuthLogin();

        $listnganh = DB::table('nganh') -> get();
        $result_listnganh = view('pages.nganh.viewnganh') -> with('viewnganh', $listnganh);
        return view('layout') -> with('pages.nganh.viewnganh', $result_listnganh);
    }

    public function addnganh(){
        $this -> AuthLogin();

        return view('pages.nganh.addnganh');
    }

    // action save mon hoc
    public function savenganh(Request $request){
        $this -> AuthLogin();

        $data = array();
        $temp_manganh = $request -> manganh;
        $data['manganh'] = $request -> manganh;
        $data['tennganh'] = $request -> tennganh;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('nganh') -> where('manganh', $temp_manganh) -> first();
        if($result){
            Session::put('message', 'ngành đã tồn tại!!!');
            return redirect::to('addnganh');
        }
        else if($request -> tennganh == ''){
            Session::put('message', 'Tên ngành học không được để trống!!!');
            return redirect::to('addnganh');
        }
        else{
            DB::table('nganh') -> insert($data);
            Session::put('message', 'Thêm ngành học thành công');
            return redirect::to('addnganh');
        }
    }

    //search
    public function search(){
        
    }

    // show - hiden mon hoc
    public function hiden_nganh($manganh){
        $this -> AuthLogin();

        DB::table('nganh') -> where('manganh', $manganh) -> update(['status'=> 0]);
        return redirect::to('viewnganh');
    }

    public function show_nganh($manganh){
        $this -> AuthLogin();

        DB::table('nganh') -> where('manganh', $manganh) -> update(['status'=> 1]);
        return redirect::to('viewnganh');
    }

    // GET edit mon hoc
    public function editnganh($manganh){
        $this -> AuthLogin();

        $listnganh = DB::table('nganh') -> where('manganh', $manganh) -> get();
        $result_editnganh = view('pages.nganh.editnganh') -> with('editnganh', $listnganh);
        return view('layout') -> with('pages.nganh.editnganh', $result_editnganh);
        return redirect::to('editnganh');

    }
    // POST edit mon hoc
    public function action_editnganh(Request $request, $manganh){
        $this -> AuthLogin();

        $data = array();
        $data['nganh'] = $request -> tennganh;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> tennganh == ''){
            Session::put('message', 'Tên ngành không được để trống!!!');
            return redirect::to('editnganh');
        }
        else{
            DB::table('nganh') -> where('manganh', $manganh) -> update($data);
            Session::put('message', 'Cập nhật thành công');
            return redirect::to('viewnganh');
        }
    }

    // delete mon hoc
    public function deletenganh($manganh){
        $this -> AuthLogin();
        
        DB::table('nganh') -> where('manganh', $manganh) -> delete();
        return redirect::to('viewnganh');
    }
}
