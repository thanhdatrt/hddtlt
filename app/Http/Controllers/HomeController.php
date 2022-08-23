<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PharIo\Manifest\Url;

session_start();

class HomeController extends Controller
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
    
    public $data = [];

    public function index(){
        return view('login');
    }
    
    // pages/home
    public function home(){
        $this -> AuthLogin();

        $sinhvien   = DB::table('sinhvien')->get();
        $monhoc     = DB::table('monhoc')->get();
        $lop        = DB::table('lop')->get();
        $htdt       = DB::table('htdt')->get();

        $countsinhvien  = count($sinhvien);
        $countmonhoc    = count($monhoc);
        $countlop       = count($lop);
        $counthtdt      = count($htdt);

        return view('pages.home', $this->data) 
        -> with('sinhvien', $countsinhvien) 
        -> with('monhoc', $countmonhoc)
        -> with('lop', $countlop)
        -> with('htdt', $counthtdt);
    }

    // xu ly dang nhap
    public function dashboard(Request $request){
        $email = $request->email;
        $password = md5($request->password);

        $result = DB::table('user')->where('email', $email)->where('password', $password)->first();

        if($result) {
            if($result-> status == 0){
                Session::put('message', 'Bạn chưa có quyền đăng nhập');
                return back();
            } else{
                Session::put('name', $result -> name);
                Session::put('email', $result -> email);
                Session::put('avatar', $result -> avatar);
                Session::put('id', $result -> id);
                return Redirect::to('/home');
            }
        }
        else {
            Session::put('message', 'Tài khoản hoặc mật khẩu của bạn không đúng, vui lòng thử lại');
            return Redirect::to('/');
        }
    }

    // dang xuat
    public function logout(){
        Session::put('name', null);
        Session::put('id', null);
        Session::put('email', null);
        Session::put('avatar', null);
        return Redirect::to('/');
    }
    
    //
}
