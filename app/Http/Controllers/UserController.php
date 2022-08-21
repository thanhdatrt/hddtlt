<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function profile(Request $request){
        $userid = $request->session()->get('id');
        $user = DB::table('user') ->where('id', $userid) -> get();
        return view('pages.user.profile', compact('user'));
    }

    public function capnhattt(Request $request){
        $userid     = $request->session()->get('id');
        $name       = $request -> hoten;
        $phone      = $request -> phone;
        $avatar     = $request -> avatar;
        $data       = array();
        if($name =='' || $phone == '' || $avatar == ''){
            Session::put('message', 'Các trường không được để trống!!!');
            return back();
        } else {
            $data       = [
                'name' => $name,
                'phone' => $phone,
                'avatar' => $avatar,
            ];
            Session::put('message', 'Cập nhật thành công!!!');
            DB::table('user') -> where('id', $userid) -> update($data);
            return back();
        }
        
    }

    public function doimatkhau(Request $request){
        $userid     = $request->session()->get('id');
        $mkcu   = $request -> mkcu;
        $mkmoi  = $request -> mkmoi;
        $mkmoi1 = $request -> mkmoi1;
        $encode = md5($mkcu);
        $result = DB::table('user') -> where('id', $userid) -> get();
        foreach ($result as $key => $value) {
            $pw = $value -> password;
        }
        if($encode != $pw){            
            Session::put('message', 'Mật khẩu không đúng!!!');
            return back();
        } else if($mkmoi != $mkmoi1) {
            Session::put('message', 'Mật khẩu không khớp!!!');
            return back();
        } else if($encode == md5($mkmoi)){
            Session::put('message', 'Mật khẩu mới không được trùng với mật khẩu cũ!!!');
            return back();
        } else if(strlen($mkmoi) < 8){
            Session::put('message', 'Mật khẩu phải từ 8 kí tự!!!');
            return back();
        } else {
            $data = [
                'password' => md5($mkmoi),
            ];
            Session::put('message', 'Cập nhật thành công!!!');
            DB::table('user') -> where('id', $userid) -> update($data);
            return back();
        }
    }

    public function AccountManager(Request $request) {
        $users = DB::table('user') -> paginate(15);
        $users -> appends($request -> all());
        return view("pages.user.AccountManagerment") -> with('users', $users);
    }

    public function hidden_user(Request $request, $id){
        $userid = $request->session()->get('id');
        if($id == $userid){
            Session::put('message', 'Bạn đang đăng nhập bẳng tài khoản này, không thể thu hồi quyền được!!!');
            return back();
        }
        DB::table('user') -> where('id', $id) -> update(['status'=> 0]);
        return back();
    }

    public function show_user(Request $request, $id){
        DB::table('user') -> where('id', $id) -> update(['status'=> 1]);
        return back();
    }

    public function deleteuser(Request $request, $id){
        $userid = $request->session()->get('id');
        if($id == $userid){
            Session::put('message', 'Tài khoản đang đăng nhập không thể xóa!!!');
            return back();
        }
        DB::table('user') -> where('id', $id) -> delete();
        return back();
    }

    public function addUser(Request $request){
        $email      = $request -> email;
        $password   = md5($request -> password);
        $name       = $request -> name;
        $data       = array();
        $user       = DB::table('user') -> where('email', $email) -> get();
        if(count($user) > 0){
            Session::put('adduser', 'Email đã được đăng ký!!!');
            return back();
        } else {
            $data       = [
                'email'     => $email,
                'password'  => $password,
                'name'      => $name,
                'created_at' => new DateTime('now'),
                'status'    => 0,
                'avatar'    => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRy2jgWhBxj4H8yggOmCqvYvNQ2jwTaOcBGmg&usqp=CAU',
            ];
            Session::put('adduser', 'Thêm thành công!!!');
            DB::table('user') -> insert($data);
            return back();
        }
    }
}
