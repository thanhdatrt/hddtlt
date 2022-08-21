<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LopController extends Controller
{
    public function viewlop(Request $request){
        if(isset($_GET['keyword'])){
            $keyword = $_GET['keyword'];
            $listsearch = DB::table('lop') -> where('tenlop', 'LIKE', '%'.$keyword.'%') ->orWhere('malop', 'LIKE', '%'.$keyword.'%') -> paginate(2);
            $result_listlop = view('pages.lop.viewlop') -> with('viewlop', $listsearch);
            $listsearch -> appends($request -> all());
            return view('layout') -> with('pages.lop.viewlop', $result_listlop);
        } 
        else{
            $listlop = DB::table('lop') -> get();
            $result_listlop = view('pages.lop.viewlop') -> with('viewlop', $listlop);
            return view('layout') -> with('pages.lop.viewlop', $result_listlop);
        }
    }

    public function addlop(){
        return view('pages.lop.addlop');
    }

    // action save mon hoc
    public function savelop(Request $request){
        $data = array();
        $temp_malop = $request -> malop;
        $data['malop'] = $request -> malop;
        $data['tenlop'] = $request -> tenlop;

        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['create_at'] = new dateTime('now');
        
        $result = DB::table('lop') -> where('malop', $temp_malop) -> first();
        if($result){
            Session::put('message', 'Khóa đã tồn tại!!!');
            return redirect::to('addlop');
        }
        else if($request -> tenlop == ''){
            Session::put('message', 'Tên khóa học không được để trống!!!');
            return redirect::to('addlop');
        }
        else{
            DB::table('lop') -> insert($data);
            Session::put('message', 'Thêm khóa học thành công');
            return redirect::to('addlop');
        }
    }

    //search
    public function search(){
        
    }

    // show - hiden mon hoc
    public function hiden_lop($malop){
        DB::table('lop') -> where('malop', $malop) -> update(['status'=> 0]);
        return redirect::to('viewlop');
    }

    public function show_lop($malop){
        DB::table('lop') -> where('malop', $malop) -> update(['status'=> 1]);
        return redirect::to('viewlop');
    }

    // GET edit mon hoc
    public function editlop($malop){
        $listlop = DB::table('lop') -> where('malop', $malop) -> get();
        $result_editlop = view('pages.lop.editlop') -> with('editlop', $listlop);
        return view('layout') -> with('pages.lop.editlop', $result_editlop);
        return redirect::to('editlop');

    }
    // POST edit mon hoc
    public function action_editlop(Request $request, $malop){
        $data = array();

        $data['tenlop'] = $request -> tenlop;
        $status = $request -> hienthi;
        if($status == 'on'){
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        $data['update_at'] = new dateTime('now');
        
        if($request -> tenlop == ''){
            Session::put('message', 'Tên lớp không được để trống!!!');
            return redirect::to('editlop');
        }
        else{
            DB::table('lop') -> where('malop', $malop) -> update($data);
            Session::put('message', 'Cập nhật thành công');
            return redirect::to('viewlop');
        }
    }

    // delete mon hoc
    public function deletelop($malop){
        DB::table('lop') -> where('malop', $malop) -> delete();
        return redirect::to('viewlop');
    }
}
