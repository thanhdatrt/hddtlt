<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PharIo\Manifest\Url;
use App\Http\Controllers\timestamp;

class HeController extends Controller
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

    public function viewhe(){
        $this -> AuthLogin();

        $listhe = DB::table('he') -> get();
        $result_listhe = view('pages.he.viewhe') -> with('viewhe', $listhe);
        return view('layout') -> with('pages.he.viewhe', $result_listhe);
    }

    public function addhe(){
        $this -> AuthLogin();

        return view('pages.he.addhe');
    }

    // action save mon hoc
    public function savehe(Request $request){
        $this -> AuthLogin();

        $data = array();
        $temp_mahe = $request -> mahe;
        $data['mahe'] = $request -> mahe;
        $data['he'] = $request -> tenhe;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('he') -> where('mahe', $temp_mahe) -> first();
        if($result){
            Session::put('message', 'Hệ đã tồn tại!!!');
            return redirect::to('addhe');
        }
        else if($request -> tenhe == ''){
            Session::put('message', 'Tên hệ không được để trống!!!');
            return redirect::to('addhe');
        }
        else{
            DB::table('he') -> insert($data);
            Session::put('message', 'Thêm môn học thành công');
            return redirect::to('addhe');
        }
    }

    // show - hiden mon hoc
    public function hiden_he($mahe){
        $this -> AuthLogin();

        DB::table('he') -> where('mahe', $mahe) -> update(['status'=> 0]);
        return redirect::to('viewhe');
    }

    public function show_he($mahe){
        $this -> AuthLogin();

        DB::table('he') -> where('mahe', $mahe) -> update(['status'=> 1]);
        return redirect::to('viewhe');
    }

    // GET edit mon hoc
    public function edithe($mahe){
        $this -> AuthLogin();

        $listhe = DB::table('he') -> where('mahe', $mahe) -> get();
        $result_edithe = view('pages.he.edithe') -> with('edithe', $listhe);
        return view('layout') -> with('pages.he.edithe', $result_edithe);
        return redirect::to('edithe');

    }
    // POST edit mon hoc
    public function action_edithe(Request $request, $mahe){
        $this -> AuthLogin();

        $data = array();
        $data['he'] = $request -> tenhe;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> tenhe == ''){
            Session::put('message', 'Tên hệ không được để trống!!!');
            return redirect::to('edithe');
        }
        else{
            DB::table('he') -> where('mahe', $mahe) -> update($data);
            Session::put('message', 'Cập nhật thành công');
            return redirect::to('viewhe');
        }
    }

    // delete mon hoc
    public function deletehe($mahe){
        $this -> AuthLogin();
        
        DB::table('he') -> where('mahe', $mahe) -> delete();
        return redirect::to('viewhe');
    }
}
